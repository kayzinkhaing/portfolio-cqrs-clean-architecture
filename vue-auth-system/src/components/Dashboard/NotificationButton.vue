<template>
  <div class="relative">
    <!-- Bell Icon Button -->
    <button @click="toggleDropdown" class="relative p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700 transition-all duration-300">
      <BellIcon class="w-6 h-6 text-gray-600 dark:text-slate-300" />

      <!-- Unread badge -->
      <div v-if="unreadCount > 0" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full flex items-center justify-center">
        <span class="text-xs text-white font-bold">{{ unreadCount }}</span>
      </div>
    </button>

    <!-- Dropdown -->
    <div v-if="showDropdown" class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg overflow-hidden z-50">
      <div class="max-h-96 overflow-y-auto">
        <div
          v-for="notif in notifications"
          :key="notif.id"
          class="p-3 flex justify-between items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition"
        >
          <div>
            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ notif.name || 'No name' }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ notif.model }}</p>
          </div>
          <button
            v-if="!notif.status"
            @click="markAsRead(notif.id)"
            class="text-green-500 text-sm"
          >
            Mark Read
          </button>
        </div>

        <div v-if="notifications.length === 0" class="p-4 text-center text-gray-500 dark:text-gray-400">
          No notifications
        </div>
      </div>

      <div class="p-2 border-t border-gray-200 dark:border-gray-700 flex justify-center">
        <button @click="markAllRead" class="text-xs text-gray-600 dark:text-gray-300 hover:underline">
          Mark all as read
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { BellIcon } from '@heroicons/vue/24/outline'
import { useNotifications } from '../../composables/useNotifications'
const showDropdown = ref(false)
const toggleDropdown = () => (showDropdown.value = !showDropdown.value)

const { notifications, unreadCount, markAsRead } = useNotifications('contact-message')
// console.log('notifications:', notifications.value, 'and unread count',unreadCount.value)
const markAllRead = () => markAsRead()

// close on outside click
const root = ref<HTMLElement | null>(null)
function onClickOutside(e: MouseEvent) {
  if (!root.value) return
  if (!root.value.contains(e.target as Node)) showDropdown.value = false
}
onMounted(() => document.addEventListener('click', onClickOutside))
onUnmounted(() => document.removeEventListener('click', onClickOutside))
</script>
