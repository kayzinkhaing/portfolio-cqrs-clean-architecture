<template>
  <section class="work-view min-h-screen py-20 px-6">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-16">
        <div class="inline-block">
          <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent mb-4">
            Featured Projects
          </h1>
          <div class="h-1 w-24 bg-gradient-to-r from-indigo-500 to-purple-500 rounded mx-auto"></div>
        </div>
        <p class="text-white text-lg mt-6 max-w-2xl mx-auto">
          Explore my latest work and creative solutions built with modern technologies
        </p>
      </div>

      <!-- Initial Loading -->
      <div v-if="loading" class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
        <ProjectCardSkeleton v-for="n in 6" :key="n" />
      </div>

      <!-- Error -->
      <div v-else-if="error" class="text-center py-20">
        <p class="text-red-400">{{ error }}</p>
        <button 
          @click="loadProjects" 
          class="mt-4 px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors"
        >
          Try Again
        </button>
      </div>

      <!-- Empty -->
      <div v-else-if="projects.length === 0" class="text-center py-20">
        <p class="text-slate-400">No projects to showcase yet</p>
      </div>

      <!-- Projects -->
      <div v-else>
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
          <!-- If loading more, show skeletons -->
          <template v-if="loadingMore">
            <ProjectCard v-for="project in projects.slice(0,6)" :key="project.id" :project="project" />
            <ProjectCardSkeleton v-for="n in 3" :key="'skeleton-'+n" />
          </template>
          <template v-else>
            <ProjectCard v-for="project in visibleProjects" :key="project.id" :project="project" />
          </template>
        </div>

        <!-- See More Button -->
        <div v-if="projects.length > 6" class="text-center mt-10">
          <button 
            @click="toggleSeeMore"
            class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors"
          >
            {{ showAll ? 'Show Less' : 'See More Projects' }}
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import ProjectCard from '@/components/portfolio/ProjectCard.vue'
import ProjectCardSkeleton from '../../components/portfolio/ProjectCardSkeleton.vue'
import { gqlClient } from '../../api/gql/client'
import { GET_PROJECTS } from '../../api/queries/projectQuery'
import type { Project } from '../../types/project'

const projects = ref<Project[]>([])
const loading = ref(true)
const loadingMore = ref(false)
const error = ref<string | null>(null)
const showAll = ref(false)

const visibleProjects = computed(() => showAll.value ? projects.value : projects.value.slice(0, 6))

async function loadProjects() {
  loading.value = true
  error.value = null
  try {
    const { data } = await gqlClient.query({
      query: GET_PROJECTS,
      fetchPolicy: 'cache-first',
    })
    projects.value = data.projects ?? []
  } catch (err: any) {
    error.value = err.message || 'Failed to load projects'
  } finally {
    loading.value = false
  }
}

function toggleSeeMore() {
  if (!showAll.value) {
    // Simulate loading state for "See More"
    loadingMore.value = true
    setTimeout(() => {
      showAll.value = true
      loadingMore.value = false
    }, 800) // you can adjust the delay (ms)
  } else {
    showAll.value = false
  }
}

onMounted(loadProjects)
</script>
