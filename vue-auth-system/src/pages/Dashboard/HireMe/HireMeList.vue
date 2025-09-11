<template>
  <div>
    <Header title="Hire Me Messages" />

    <div v-if="loading" class="text-center py-10">Loading messages...</div>
    <div v-else-if="error" class="text-center py-10 text-red-500">{{ error.message }}</div>

    <div v-else class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">
      <MessagesTable
        :messages="paginatedMessages"
        @mark-as-read="handleMarkAsRead"
        @request-delete="handleRequestDelete"
      />

      <Pagination
        :current-page="currentPage"
        :total-pages="totalPages"
        @change-page="goToPage"
      />
    </div>

    <!-- Delete confirmation modal -->
    <DeleteModal
      v-if="deleteModalVisible"
      @confirm="confirmDelete"
      @cancel="deleteModalVisible = false"
    />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useContactMessages } from '../../../composables/useContactMessages'
import MessagesTable from '@/components/HireMeMessages/MessagesTable.vue'
import Pagination from '@/components/common/Pagination.vue'
import Header from '@/components/common/Header.vue'
import DeleteModal from '@/components/Dashboard/DeleteModal.vue'
import { deleteContactMessage, updateContactMessage } from '../../../api/commands/contactMessageCommand'
import type { ContactMessage } from '../../../types/contact'

const {
  loading,
  error,
  paginatedMessages,
  currentPage,
  totalPages,
  goToPage,
  messages,
} = useContactMessages()

const deleteModalVisible = ref(false)
const messageToDelete = ref<ContactMessage | null>(null)

// --------------------
// Mark as Read
// --------------------
async function handleMarkAsRead(id: string | number) {
  const msg = messages.value.find(m => m.id === id)
  if (!msg || msg.is_read) return

  const updated = await updateContactMessage(id, { is_read: true })
  if (updated) {
    msg.is_read = true
    // Optional: update notifications count if you use useNotifications
  }
}

// --------------------
// Delete message
// --------------------
function handleRequestDelete(msg: ContactMessage) {
  messageToDelete.value = msg
  deleteModalVisible.value = true
}

async function confirmDelete() {
  if (!messageToDelete.value) return

  const success = await deleteContactMessage(messageToDelete.value.id)
  if (success) {
    const index = messages.value.findIndex(m => m.id === messageToDelete.value?.id)
    if (index !== -1) messages.value.splice(index, 1)
  }

  deleteModalVisible.value = false
  messageToDelete.value = null
}
</script>
