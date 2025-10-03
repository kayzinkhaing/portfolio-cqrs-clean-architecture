<template>
  <article
    class="group relative bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-2xl overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-transform duration-300 cursor-pointer"
    @click="openModal"
  >
    <!-- Project Image -->
    <div class="relative h-48 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 overflow-hidden rounded-t-2xl">
      <img
        :src="getProjectImage(project)"
        :alt="project.title"
        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
        loading="lazy"
      />
      <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>

      <!-- Status Badge -->
      <span
        :class="getStatusBadgeClass(project.status?.name)"
        class="absolute top-3 right-3 px-3 py-1 text-xs font-semibold rounded-full backdrop-blur-sm"
      >
        {{ project.status?.name || "Active" }}
      </span>
    </div>

    <!-- Project Info -->
    <div class="p-5">
      <h3 class="text-lg font-bold text-white mb-2 group-hover:text-indigo-300 transition-colors">
        {{ project.title }}
      </h3>

      <p class="text-white text-sm mb-3 line-clamp-3">
        {{ project.description }}
      </p>

      <!-- Technologies -->
      <div class="flex flex-wrap gap-2 mb-3">
        <span
          v-for="tech in project.technologies?.slice(0, 4)"
          :key="tech.id"
          class="px-2 py-1 text-xs font-medium rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100"
        >
          {{ tech.name }}
        </span>

        <span
          v-if="project.technologies?.length > 4"
          class="px-2 py-1 text-xs font-medium rounded-full bg-gray-700/30 text-white border border-gray-600/30"
        >
          +{{ project.technologies.length - 4 }} more
        </span>
      </div>

      <!-- Timeline -->
      <div class="flex items-center justify-between text-xs text-gray-300 border-t border-slate-700/50 pt-2">
        <span>{{ formatDate(project.start_date) }}</span>
        <span>to</span>
        <span>{{ formatDate(project.end_date) }}</span>
      </div>
    </div>

    <!-- Modal -->
    <ProjectDetailModal
      v-if="showModal"
      :project="project"
      @close="showModal = false"
    />
  </article>
</template>

<script setup lang="ts">
import type { Project } from '@/types/project'
import { ref } from 'vue'
import { getProjectImage, getStatusBadgeClass, formatDate } from '@/utils/projectHelpers'
import ProjectDetailModal from './ProjectDetailModal.vue'

defineProps<{
  project: Project
}>()

const showModal = ref(false)

const openModal = () => {
  showModal.value = true
}
</script>

<style scoped>
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
