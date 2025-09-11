// src/composables/useNotifications.ts
import { ref, onMounted, onUnmounted } from "vue";
import { echo } from "@/plugins/echo";
import { getUnreadContactMessages } from "@/api/queries/contactMessageQuery";
import { updateContactMessage } from "@/api/commands/contactMessageCommand";

export interface Notification {
  id: string;
  name?: string;
  status?: boolean; // true = read, false = unread
  action: string;
  model: string;
}

export function useNotifications(model: string) {
  const notifications = ref<Notification[]>([]);
  const unreadCount = ref(0);
  let channel: any = null;
  const channelName = `model-changed-${model}`;

  // -------------------------
  // Normalize any incoming event
  // -------------------------
  function normalizeEvent(event: any): Notification {
    const data = event?.payload ? event : { payload: event };
    const p = data.payload ?? {};

    return {
      id: String(data.id ?? p.id ?? Date.now()),
      name: p.name ?? p.title ?? p.message ?? "No name",
      status: p.is_read ?? false, // false = unread
      action: data.action ?? p.action ?? "update",
      model: data.model ?? model,
    };
  }

  // -------------------------
  // Add a new notification
  // -------------------------
  function addNotification(rawEvent: any) {
    const n = normalizeEvent(rawEvent);
    notifications.value.unshift(n);
    if (!n.status) unreadCount.value++;
  }

  // -------------------------
  // Mark one or all notifications as read (with DB update)
  // -------------------------
  async function markAsRead(id?: string) {
    if (id) {
      const idx = notifications.value.findIndex((n) => n.id === id);
      if (idx !== -1 && !notifications.value[idx].status) {
        // Optimistic UI update
        notifications.value[idx].status = true;
        unreadCount.value = Math.max(0, unreadCount.value - 1);

        // Update backend
        try {
          await updateContactMessage(Number(id), { is_read: true });
        } catch (err) {
          console.error(`[useNotifications] Failed to mark message ${id} as read`, err);
          // rollback in case of error
          notifications.value[idx].status = false;
          unreadCount.value++;
        }
      }
    } else {
      // Mark all as read
      const unreadMessages = notifications.value.filter((n) => !n.status);

      // Optimistic UI update
      notifications.value.forEach((n) => (n.status = true));
      unreadCount.value = 0;

      try {
        await Promise.all(
          unreadMessages.map((n) => updateContactMessage(Number(n.id), { is_read: true }))
        );
      } catch (err) {
        console.error("[useNotifications] Failed to mark all messages as read", err);
        // Rollback failed messages
        unreadMessages.forEach((n) => {
          n.status = false;
        });
        unreadCount.value = notifications.value.filter((n) => !n.status).length;
      }
    }
  }

  // -------------------------
  // Fetch unread notifications from GraphQL (Mongo)
  // -------------------------
  async function fetchUnreadNotifications() {
    try {
      const messages = await getUnreadContactMessages(); // must return array only

      notifications.value.splice(
        0,
        notifications.value.length,
        ...messages.map((msg) => ({
          id: String(msg.id),
          name: msg.name,
          status: msg.is_read ?? false,
          action: "create",
          model,
        }))
      );

      // calculate unread count
      unreadCount.value = notifications.value.filter((n) => !n.status).length;
    } catch (err) {
      console.error("[useNotifications] Fetch unread notifications failed", err);
    }
  }

  // -------------------------
  // Lifecycle hooks
  // -------------------------
  onMounted(() => {
    fetchUnreadNotifications();

    // Real-time notifications via Laravel Echo
    channel = echo.channel(channelName);
    channel.listen(".model.changed", (event: any) => addNotification(event));
    channel.listen("model.changed", (event: any) => addNotification(event));
  });

  onUnmounted(() => {
    if (channel) {
      try {
        channel.stopListening?.(".model.changed");
        channel.stopListening?.("model.changed");
      } catch {}
      try {
        echo.leave?.(channelName);
      } catch {}
      channel = null;
    }
  });

  return { notifications, unreadCount, markAsRead };
}
