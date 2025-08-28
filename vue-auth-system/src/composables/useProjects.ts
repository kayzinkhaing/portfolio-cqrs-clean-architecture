import { ref, onMounted, computed } from 'vue'
import { gqlClient } from '../api/gql/client'
import { GET_PROJECTS } from '../api/queries/projectQuery'

// Types
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
  description: string
  status?: Status
  start_date: string
  end_date: string
  is_featured: boolean
  technologies: Technology[]
}

export function useProjects() {
  const projects = ref<Project[]>([])
  const loading = ref(true)
  const error = ref<string | null>(null)
  const showAll = ref(false)

  // Computed visible projects
  const visibleProjects = computed(() =>
    showAll.value ? projects.value : projects.value.slice(0, 6)
  )

  // Fetch projects
  async function loadProjects() {
    loading.value = true
    error.value = null
    try {
      const { data } = await gqlClient.query({
        query: GET_PROJECTS,
        fetchPolicy: 'no-cache',
      })
      projects.value = data.projects ?? []
    } catch (err: any) {
      console.error('Error fetching projects:', err)
      error.value = err.message || 'Failed to load projects'
    } finally {
      loading.value = false
    }
  }

  // Utility functions
  const getProjectImage = (project: Project): string => {
    const placeholderImages = [
      'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=400&h=300&fit=crop&crop=entropy&cs=tinysrgb',
      'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=300&fit=crop&crop=entropy&cs=tinysrgb',
      'https://images.unsplash.com/photo-1504639725590-34d0984388bd?w=400&h=300&fit=crop&crop=entropy&cs=tinysrgb',
      'https://images.unsplash.com/photo-1517180102446-f3ece451e9d8?w=400&h=300&fit=crop&crop=entropy&cs=tinysrgb',
      'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=400&h=300&fit=crop&crop=entropy&cs=tinysrgb'
    ]
    return placeholderImages[project.id % placeholderImages.length]
  }

  const getStatusBadgeClass = (status?: string): string => {
    const statusClasses: Record<string, string> = {
      'Completed': 'bg-green-500/20 text-green-300 border border-green-500/30',
      'In Progress': 'bg-blue-500/20 text-blue-300 border border-blue-500/30',
      'Planning': 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30',
      'On Hold': 'bg-orange-500/20 text-orange-300 border border-orange-500/30',
      'Active': 'bg-indigo-500/20 text-indigo-300 border border-indigo-500/30'
    }
    return statusClasses[status || 'Active'] || statusClasses['Active']
  }

  const formatDate = (dateString: string): string => {
    if (!dateString) return 'Ongoing'
    try {
      const date = new Date(dateString)
      return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' })
    } catch {
      return dateString
    }
  }

  onMounted(loadProjects)

  return {
    projects,
    loading,
    error,
    showAll,
    visibleProjects,
    loadProjects,
    getProjectImage,
    getStatusBadgeClass,
    formatDate
  }
}
