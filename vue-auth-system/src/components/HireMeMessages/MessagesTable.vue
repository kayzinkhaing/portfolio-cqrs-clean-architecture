<template>
  <div>
    <table class="min-w-full text-sm text-left">
      <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200">
        <tr>
          <th class="px-6 py-3">Name</th>
          <th class="px-6 py-3">Email</th>
          <th class="px-6 py-3">Subject</th>
          <th class="px-6 py-3">Message</th>
          <th class="px-6 py-3">Status</th>
          <th class="px-6 py-3 text-right">Actions</th>
        </tr>
      </thead>
      <transition-group tag="tbody" name="fade-slide">
        <tr
          v-for="msg in messages"
          :key="msg.id"
          class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
        >
          <td class="px-6 py-4 font-medium">{{ msg.name }}</td>
          <td class="px-6 py-4">{{ msg.email }}</td>
          <td class="px-6 py-4">{{ msg.subject }}</td>
          <td class="px-6 py-4"><span class="line-clamp-2" :title="msg.message">{{ msg.message }}</span></td>
          <td class="px-6 py-4">{{ msg.is_read ? 'Read' : 'Unread' }}</td>
          <td class="px-6 py-4 text-right space-x-2">
            <!-- <button
              @click="$emit('mark-as-read', msg.id)"
              class="text-green-600 hover:text-green-800"
              :disabled="msg.is_read"
            >
              ✅ Mark as Read
            </button> -->
            <button
              @click="$emit('request-delete', msg)"
              class="text-red-600 hover:text-red-800"
            >
              🗑 Delete
            </button>
          </td>
        </tr>
      </transition-group>
    </table>
  </div>
</template>

<script setup lang="ts">
import type { ContactMessage } from '../../types/contact'
defineProps<{ messages: ContactMessage[] }>()
</script>

