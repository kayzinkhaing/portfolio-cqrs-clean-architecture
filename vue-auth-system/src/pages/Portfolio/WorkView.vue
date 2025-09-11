<template>
  <section class="work-view min-h-screen py-20 px-6">
    <div class="max-w-7xl mx-auto">

      <!-- Header -->
      <div class="text-center mb-16">
        <div class="inline-block">
          <h1
            class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent mb-4"
          >
            Featured Projects
          </h1>
          <div class="h-1 w-24 bg-gradient-to-r from-indigo-500 to-purple-500 rounded mx-auto"></div>
        </div>
        <p class="text-white text-lg mt-6 max-w-2xl mx-auto">
          Explore my latest work and creative solutions built with modern technologies
        </p>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
        <ProjectCardSkeleton v-for="n in 6" :key="n" />
      </div>

      <!-- Error -->
      <div v-else-if="error" class="text-center py-20">
        <p class="text-red-400">{{ error.message }}</p>
        <button 
          @click="refetch()"
          class="mt-4 px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors"
        >
          Try Again
        </button>
      </div>

      <!-- Empty -->
      <div v-else-if="sortedProjects.length === 0" class="text-center py-20">
        <p class="text-slate-400">No projects to showcase yet</p>
      </div>

      <!-- Projects Grid -->
      <div v-else class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
        <!-- Project Cards -->
        <ProjectCard
          v-for="project in visibleProjects"
          :key="project.id"
          :project="project"
        />

        <!-- Skeletons while loading more -->
        <ProjectCardSkeleton
          v-for="n in loadingMore ? 3 : 0"
          :key="'skeleton-' + n"
        />
      </div>

      <!-- See More Button -->
      <div v-if="sortedProjects.length > 6" class="text-center mt-10">
        <button 
          @click="toggleSeeMore"
          class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors"
        >
          {{ showAll ? 'Show Less' : 'See More Projects' }}
        </button>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useProjects } from '../../composables/useProjects'
import ProjectCard from '@/components/portfolio/ProjectCard.vue'
import ProjectCardSkeleton from '@/components/portfolio/ProjectCardSkeleton.vue'

// ----------------------
// Projects Composable (same as ProjectList)
// ----------------------
const { projects, loading, error, refetch } = useProjects(1, 20) // Get 20 projects for portfolio

// ----------------------
// Show More / Loading More
// ----------------------
const showAll = ref(false)
const loadingMore = ref(false)

// ----------------------
// Computed Properties
// ----------------------
const sortedProjects = computed(() => [...projects.value].sort((a,b) => Number(b.id) - Number(a.id)))

// Visible projects (See More / Show Less)
const visibleProjects = computed(() => showAll.value ? sortedProjects.value : sortedProjects.value.slice(0, 6))

// ----------------------
// Toggle See More
// ----------------------
function toggleSeeMore() {
  if (!showAll.value) {
    loadingMore.value = true
    setTimeout(() => {
      showAll.value = true
      loadingMore.value = false
    }, 500)
  } else {
    showAll.value = false
  }
}
</script>