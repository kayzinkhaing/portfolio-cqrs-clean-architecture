<script setup lang="ts">
import { defineProps, defineEmits, computed } from 'vue'

interface Props {
  currentPage: number
  lastPage: number
}

const props = defineProps<Props>()

const emit = defineEmits<{
  (e: 'page-change', page: number): void
}>()

/**
 * Emit page change event only if
 * - page is within valid range
 * - page is different from current page
 */
function changePage(page: number): void {
  if (page > 0 && page <= props.lastPage && page !== props.currentPage) {
    emit('page-change', page)
  }
}

/**
 * Compute page numbers to show with ellipsis '...'
 * Always show first, last, and current ± delta pages.
 */
const pages = computed<(number | string)[]>(() => {
  const { lastPage, currentPage } = props
  const delta = 2
  const range: number[] = []
  const rangeWithDots: (number | string)[] = []
  let previous: number | null = null

  for (let i = 1; i <= lastPage; i++) {
    if (i === 1 || i === lastPage || (i >= currentPage - delta && i <= currentPage + delta)) {
      range.push(i)
    }
  }

  for (const page of range) {
    if (previous !== null) {
      if (page - previous === 2) {
        rangeWithDots.push(previous + 1)
      } else if (page - previous > 2) {
        rangeWithDots.push('...')
      }
    }
    rangeWithDots.push(page)
    previous = page
  }

  return rangeWithDots
})
</script>

<template>
  <nav v-if="props.lastPage > 1" aria-label="Pagination navigation"
    class="flex justify-center items-center space-x-1 mt-6 select-none">
    <button @click="changePage(props.currentPage - 1)" :disabled="props.currentPage === 1"
      class="px-3 py-1 rounded border border-gray-300 bg-white hover:bg-gray-100 disabled:opacity-50"
      aria-label="Previous page">
      Prev
    </button>
  
    <button v-for="page in pages" :key="page + '-page-btn'" @click="typeof page === 'number' && changePage(page)" :class="[
          'px-3 py-1 rounded border border-gray-300',
          page === props.currentPage
            ? 'bg-indigo-600 text-white cursor-default'
            : 'bg-white hover:bg-gray-100 cursor-pointer',
          page === '...' ? 'cursor-default pointer-events-none' : ''
        ]" :disabled="page === '...'" :aria-current="page === props.currentPage ? 'page' : undefined">
      {{ page }}
    </button>
  
    <button @click="changePage(props.currentPage + 1)" :disabled="props.currentPage === props.lastPage"
      class="px-3 py-1 rounded border border-gray-300 bg-white hover:bg-gray-100 disabled:opacity-50"
      aria-label="Next page">
      Next
    </button>
  </nav>
</template>
