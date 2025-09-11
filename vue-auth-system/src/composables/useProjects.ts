// src/composables/useProjects.ts
import { ref, reactive, computed, watch } from 'vue'
import { useQuery } from '@vue/apollo-composable'
import { GET_PROJECTS } from '@/api/queries/projectQuery'
import type { Project } from '@/types/project'

export function useProjects(initialPage = 1, perPage = 5) {
  // Pagination state
  const pagination = reactive({
    current: initialPage,
    perPage,
    total: 0,
    lastPage: 1
  })

  // GraphQL query variables
  const variables = ref({
    page: pagination.current,
    per_page: pagination.perPage
  })

  // Apollo query
  const { result, loading, error, refetch } = useQuery(GET_PROJECTS, variables, {
    fetchPolicy: 'no-cache'
  })

  // Watch for page changes
  watch(
    () => pagination.current,
    (newPage) => {
      variables.value.page = newPage
      refetch(variables.value)
    }
  )

  // Computed projects array
  const projects = computed<Project[]>(() => result.value?.projects?.data ?? [])

  // Update pagination metadata whenever query result changes
  watch(result, (newResult) => {
    if (newResult?.projects) {
      const p = newResult.projects
      pagination.total = p.total
      pagination.lastPage = p.last_page
    }
  })

  // Function to go to a specific page
  function goToPage(page: number) {
    if (page < 1 || page > pagination.lastPage) return
    pagination.current = page
  }

  return {
    projects,
    loading,
    error,
    pagination,
    refetch,
    goToPage
  }
}
