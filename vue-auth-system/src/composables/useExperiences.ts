// src/composables/useExperiences.ts
import { ref, computed, onMounted } from 'vue'
import { gqlClient } from '@/api/gql/client'
import { GET_EXPERIENCES } from '@/api/queries/experienceQuery'
import type { Experience } from '@/types/experience'

export function useExperiences() {
  const experiences = ref<Experience[]>([])
  const loading = ref(true)
  const error = ref<string | null>(null)

  async function fetchExperiences() {
    loading.value = true
    error.value = null
    try {
      const { data } = await gqlClient.query({
        query: GET_EXPERIENCES,
        fetchPolicy: 'no-cache',
      })
      experiences.value = data?.experiences ?? []
    } catch (err: any) {
      error.value = err.message || 'Failed to load experiences'
    } finally {
      loading.value = false
    }
  }

  onMounted(fetchExperiences)

  const totalExperiences = computed(() => experiences.value.length)

  return {
    experiences,
    totalExperiences,
    loading,
    error,
    refetch: fetchExperiences,
  }
}
