// src/stores/experienceStore.ts
import { defineStore } from 'pinia'
import { ref } from 'vue'
import { getExperiences } from '@/api/queries/experienceQuery'

export interface Experience {
  id: string | number
  position: string
  company: string
  location?: string
  start_date?: string
  end_date?: string
  responsibilities?: string[]
  created_at?: string
  updated_at?: string
}

export const experienceStore = defineStore('experience', () => {
  const experiences = ref<Experience[]>([])
  const loading = ref(false)
  const error = ref<string | null>(null)
  let fetched = false

  const fetchExperiencesOnce = async () => {
    if (fetched) return
    loading.value = true
    error.value = null
    try {
      const data = await getExperiences()
      experiences.value = data ?? []
      fetched = true
    } catch (err: any) {
      error.value = err.message || 'Failed to load experiences'
    } finally {
      loading.value = false
    }
  }

  return { experiences, loading, error, fetchExperiencesOnce }
})
