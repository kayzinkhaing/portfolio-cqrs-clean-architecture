<template>
  <teleport to="body">
    <div
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
      @click.self="close"
    >
      <div
  class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 border border-gray-700 rounded-2xl max-w-3xl w-full overflow-y-auto max-h-[90vh] shadow-2xl p-6"
>

        <!-- Close Button -->
        <button
          @click="close"
          class="absolute top-4 right-4 text-white hover:text-gray-900 dark:hover:text-white transition-colors text-2xl font-bold"
          aria-label="Close modal"
        >
          ×
        </button>

        <!-- Project Header -->
        <h2 class="text-2xl font-bold text-white dark:text-white mb-3">
          {{ project.title }}
        </h2>
        <p class="text-gray-100 dark:text-gray-100 mb-4">
          {{ project.description }}
        </p>

        <!-- Project Images -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
          <img
            v-for="(img, idx) in project.images || [getProjectImage(project)]"
            :key="idx"
            :src="img"
            class="w-full h-40 object-cover rounded-lg"
            loading="eager"
          />
        </div>

        <!-- Technologies -->
        <div class="flex flex-wrap gap-2 mb-4">
          <span
            v-for="tech in project.technologies || []"
            :key="tech.id"
            class="px-3 py-1 text-xs font-medium rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100"
          >
            {{ tech.name }}
          </span>
        </div>

        <!-- Timeline -->
        <div class="flex items-center gap-2 text-sm text-gray-300 dark:text-gray-300 border-t border-gray-200 dark:border-gray-700 pt-3">
          <span>{{ formatDate(project.start_date) }}</span>
          <span>to</span>
          <span>{{ formatDate(project.end_date) }}</span>
        </div>
      </div>
    </div>
  </teleport>
</template>

<script setup lang="ts">
import type { Project } from '@/types/project'
import { defineEmits, onMounted, onUnmounted } from 'vue'
import { getProjectImage, formatDate } from '@/utils/projectHelpers'

defineProps<{
  project: Project
}>()

const emit = defineEmits<{
  close: []
}>()

const close = () => {
  emit('close')
}

// Close on ESC key
const handleEsc = (event: KeyboardEvent) => {
  if (event.key === 'Escape') close()
}

onMounted(() => {
  document.addEventListener('keydown', handleEsc)
})

onUnmounted(() => {
  document.removeEventListener('keydown', handleEsc)
})
</script>
