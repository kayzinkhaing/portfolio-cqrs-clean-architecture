import { ref, computed } from 'vue'
import { useQuery } from '@vue/apollo-composable'
import { GET_CONTACT_MESSAGES } from '@/api/queries/contactMessageQuery'
import type { ContactMessage } from '@/types/contact'

export function useContactMessages(perPageDefault = 5) {
  const currentPage = ref(1)
  const perPage = ref(perPageDefault)

  const { result, loading, error, refetch } = useQuery<{ contactMessages: ContactMessage[] }>(
    GET_CONTACT_MESSAGES,
    {},
    { fetchPolicy: 'no-cache', nextFetchPolicy: 'cache-and-network' }
  )

  const messages = computed(() => result.value?.contactMessages ?? [])

  const sortedMessages = computed(() =>
    [...messages.value].sort((a, b) => Number(b.id) - Number(a.id))
  )

  const totalPages = computed(() =>
    Math.max(1, Math.ceil(sortedMessages.value.length / perPage.value))
  )

  const paginatedMessages = computed(() => {
    const start = (currentPage.value - 1) * perPage.value
    return sortedMessages.value.slice(start, start + perPage.value)
  })

  function goToPage(page: number) {
    if (page < 1 || page > totalPages.value) return
    currentPage.value = page
  }

  function markAsRead(id: string | number) {
    const msg = messages.value.find(m => m.id === id)
    if (msg) msg.is_read = true
  }

  return {
    loading,
    error,
    messages,
    paginatedMessages,
    currentPage,
    totalPages,
    goToPage,
    markAsRead,
    refetch,
  }
}
