<template>
  <div>
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Education</h1>
      <RouterLink
        to="/dashboard/education/create"
        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md"
      >
        + New Education
      </RouterLink>
    </div>

    <!-- Loading / Error states -->
    <div v-if="loading" class="text-center py-10">Loading education records...</div>
    <div v-else-if="error" class="text-center py-10 text-red-500">{{ error.message }}</div>

    <!-- Table -->
    <div v-else class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">
      <table class="min-w-full text-sm text-left">
        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200">
          <tr>
            <th class="px-6 py-3">Institution</th>
            <th class="px-6 py-3">Degree</th>
            <th class="px-6 py-3">Location</th>
            <th class="px-6 py-3">Duration</th>
            <th class="px-6 py-3">Details</th>
            <th class="px-6 py-3 text-right">Actions</th>
          </tr>
        </thead>

        <transition-group tag="tbody" name="fade-slide">
          <tr
            v-for="edu in paginatedEducation"
            :key="edu.id"
            class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
          >
            <td class="px-6 py-4 font-medium">{{ edu.institution }}</td>
            <td class="px-6 py-4">{{ edu.degree }}</td>
            <td class="px-6 py-4">{{ edu.location }}</td>
            <td class="px-6 py-4">
              {{ formatDate(edu.start_date) }} -
              {{ edu.end_date ? formatDate(edu.end_date) : 'Present' }}
            </td>
            <td class="px-6 py-4">
              <span class="line-clamp-2" :title="edu.details">{{ edu.details }}</span>
            </td>
            <td class="px-6 py-4 text-right space-x-2">
              <RouterLink
                :to="`/dashboard/education/edit/${edu.id}`"
                class="text-indigo-600 hover:text-indigo-800"
              >
                <PencilIcon class="w-5 h-5 inline" />
              </RouterLink>
              <button class="text-red-600 hover:text-red-800">
                <TrashIcon class="w-5 h-5 inline" />
              </button>
            </td>
          </tr>
        </transition-group>
      </table>

      <!-- Pagination -->
      <div class="flex justify-between items-center p-4">
        <button
          @click="goToPage(currentPage - 1)"
          :disabled="currentPage === 1"
          class="px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded"
        >
          Prev
        </button>
        <span>Page {{ currentPage }} of {{ totalPages }}</span>
        <button
          @click="goToPage(currentPage + 1)"
          :disabled="currentPage === totalPages"
          class="px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded"
        >
          Next
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { RouterLink } from 'vue-router'
import { useQuery } from '@vue/apollo-composable'
import { GET_EDUCATIONS } from '@/api/queries/educationQuery'
import type { Education } from '@/types/education'

// Heroicons
import { PencilIcon, TrashIcon } from '@heroicons/vue/24/outline'

// Apollo query with cache-and-network
const { result, loading, error, refetch } = useQuery<{ educations: Education[] }>(
  GET_EDUCATIONS,
  {},
  { fetchPolicy: 'no-cache', nextFetchPolicy: 'cache-and-network' }
)


// Education list (computed, auto-updates when Apollo result changes)
const education = computed(() => result.value?.educations ?? [])

// Pagination
const currentPage = ref(1)
const perPage = ref(5)

const sortedEducation = computed(() =>
  [...education.value].sort((a, b) => Number(b.id) - Number(a.id))
)

const totalPages = computed(() =>
  Math.max(1, Math.ceil(sortedEducation.value.length / perPage.value))
)

const paginatedEducation = computed(() => {
  const start = (currentPage.value - 1) * perPage.value
  return sortedEducation.value.slice(start, start + perPage.value)
})

function goToPage(page: number) {
  if (page < 1 || page > totalPages.value) return
  currentPage.value = page
}

// Date formatter
function formatDate(dateStr: string) {
  const d = new Date(dateStr)
  return d.toLocaleDateString('en-GB', {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
  })
}
</script>

<style scoped>
/* Fade + slide up animation */
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.3s ease;
}
.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(10px);
}

/* Clamp details text */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>
