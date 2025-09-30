// src/composables/useEducations.ts
import { computed } from 'vue'
import { useQuery } from '@vue/apollo-composable'
import { GET_EDUCATIONS } from '@/api/queries/educationQuery'
import type { Education } from '@/types/education'

export function useEducations() {
  const { result, loading, error, refetch } = useQuery<{ educations: Education[] }>(
    GET_EDUCATIONS,
    {},
    { fetchPolicy: 'no-cache' }
  )

  // Computed array of educations
  const educations = computed(() => result.value?.educations ?? [])

  // Count total education records
  const totalEducations = computed(() => educations.value.length)

  return {
    educations,
    totalEducations,
    loading,
    error,
    refetch
  }
}
