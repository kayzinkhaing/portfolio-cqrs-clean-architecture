<template>
  <div>
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Dashboard Overview</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
      <div
        v-for="card in stats"
        :key="card.label"
        class="p-6 bg-white dark:bg-gray-800 rounded-xl shadow"
      >
        <div class="flex items-center justify-between">
          <h2 class="text-sm text-gray-500 dark:text-gray-400">{{ card.label }}</h2>
          <component :is="card.icon" class="w-6 h-6 text-indigo-500" />
        </div>
        <p class="mt-2 text-2xl font-semibold text-gray-900 dark:text-gray-100">
          {{ card.value }}
        </p>
      </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
      <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Recent Activity</h2>
      <ul class="space-y-3">
        <li
          v-for="(activity, index) in activities"
          :key="index"
          class="p-3 rounded-md bg-gray-50 dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200"
        >
          {{ activity }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { UserIcon, FolderIcon, AcademicCapIcon, BriefcaseIcon } from '@heroicons/vue/24/outline'

// ✅ Composables
import { useProjects } from '@/composables/useProjects'
import { useEducations } from '@/composables/useEducations'
import { useExperiences } from '@/composables/useExperiences'

// Load data
const { pagination: projectPagination } = useProjects()
const { totalEducations } = useEducations()
const { totalExperiences } = useExperiences()

// Stats
const stats = computed(() => [
  { label: 'Total Projects', value: projectPagination.total ?? 0, icon: FolderIcon },
  { label: 'Education Records', value: totalEducations.value ?? 0, icon: AcademicCapIcon },
  { label: 'Experiences', value: totalExperiences.value ?? 0, icon: BriefcaseIcon },
  { label: 'Profile Views', value: '1k', icon: UserIcon },
])

// Recent Activity (static sample)
const activities = [
  'Created new project "Portfolio Website"',
  'Updated Education: Bachelor of IT',
  'Added new Experience: Web Developer at XYZ',
]
</script>
