// src/composables/useDashboardProjects.ts
import { ref, computed, onMounted } from 'vue'
import { gqlClient } from '@/api/gql/client'
import { GET_PROJECTS } from '@/api/queries/projectQuery'

export interface Technology {
  id: number
  name: string
  icon?: string
}

export interface Status {
  id: number
  name: string
}

export interface Project {
  id: number
  title: string
  slug?: string
  description: string
  status?: Status
  start_date: string
  end_date: string
  is_featured: boolean
  technologies: Technology[]
}

export function useDashboardProjects(pageSize = 5) {
  const projects = ref<Project[]>([])
  const loading = ref(false)
  const error = ref<string | null>(null)
  const currentPage = ref(1)

  // --- Pagination computed ---
  const paginatedProjects = computed(() => {
    const start = (currentPage.value - 1) * pageSize
    const end = start + pageSize
    return projects.value.slice(start, end)
  })

  const totalPages = computed(() => Math.ceil(projects.value.length / pageSize))

  // --- Fetch projects from DB ---
  async function loadProjects(forceRefresh = false) {
    if (projects.value.length > 0 && !forceRefresh) return // Cached

    loading.value = true
    error.value = null
    try {
      const { data } = await gqlClient.query({
        query: GET_PROJECTS,
        fetchPolicy: 'no-cache', // or 'cache-first' depending on Apollo setup
      })
      // Sort by latest ID first
      projects.value = (data.projects ?? []).sort((a: Project, b: Project) => b.id - a.id)
    } catch (err: any) {
      console.error('Dashboard projects fetch error:', err)
      error.value = err.message || 'Failed to load projects'
    } finally {
      loading.value = false
    }
  }

  // --- Delete project locally ---
  function removeProject(id: number) {
    projects.value = projects.value.filter(p => p.id !== id)
  }

  // --- Navigation ---
  function goToNextPage() {
    if (currentPage.value < totalPages.value) currentPage.value++
  }
  function goToPrevPage() {
    if (currentPage.value > 1) currentPage.value--
  }

  onMounted(() => loadProjects())

  return {
    projects,
    paginatedProjects,
    loading,
    error,
    currentPage,
    totalPages,
    loadProjects,
    removeProject,
    goToNextPage,
    goToPrevPage,
  }
}
