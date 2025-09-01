<template>
  <article
    class="group relative bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-2xl overflow-hidden hover:border-indigo-500/50 transition-all duration-500 hover:transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-indigo-500/10"
  >
    <!-- Project Image -->
    <div
      class="relative h-48 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 overflow-hidden"
    >
      <img
        :src="getProjectImage(project)"
        :alt="project.title"
        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
        loading="lazy"
      />
      <div
        class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"
      ></div>

      <!-- Status Badge -->
      <div class="absolute top-4 right-4">
        <span
          :class="getStatusBadgeClass(project.status?.name)"
          class="px-3 py-1 text-xs font-semibold rounded-full backdrop-blur-sm"
        >
          {{ project.status?.name || "Active" }}
        </span>
      </div>
    </div>

    <!-- Project Content -->
    <div class="p-6">
      <h3
        class="text-xl font-bold text-white mb-3 group-hover:text-indigo-300 transition-colors"
      >
        {{ project.title }}
      </h3>

      <p class="text-white text-sm leading-relaxed mb-4 line-clamp-3">
        {{ project.description }}
      </p>

      <!-- Technologies -->
      <div class="flex flex-wrap gap-2 mb-4">
        <span
          v-for="tech in project.technologies?.slice(0, 4)"
          :key="tech.id"
          class="px-3 py-1 text-xs font-medium rounded-full bg-gradient-to-r from-indigo-500/20 to-purple-500/20 text-indigo-300 border border-indigo-500/30 hover:from-indigo-500/30 hover:to-purple-500/30 transition-colors"
        >
          {{ tech.name }}
        </span>

        <span
          v-if="project.technologies?.length > 4"
          class="px-3 py-1 text-xs font-medium rounded-full bg-slate-700/30 text-slate-400 border border-slate-600/30"
        >
          +{{ project.technologies.length - 4 }} more
        </span>
      </div>

      <!-- Project Timeline -->
      <div
        class="flex items-center justify-between text-xs text-white border-t border-slate-700/50 pt-4"
      >
        <div class="flex items-center gap-1">
          <svg
            class="w-3 h-3"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
            />
          </svg>
          <span>{{ formatDate(project.start_date) }}</span>
        </div>
        <div class="flex items-center gap-1">
          <span>to</span>
          <span>{{ formatDate(project.end_date) }}</span>
        </div>
      </div>
    </div>
  </article>
</template>

<script setup lang="ts">
import type { Project } from "../../types/project";
import {
  getProjectImage,
  getStatusBadgeClass,
  formatDate,
} from "../../utils/projectHelpers";

defineProps<{
  project: Project;
}>();
</script>

<style scoped>
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
