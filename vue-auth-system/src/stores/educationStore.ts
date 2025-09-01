import { reactive } from 'vue'
import { getEducations } from '@/api/queries/educationQuery'

// Type definition for Education
export interface Education {
  id: string | number
  user_id?: string | null
  institution: string
  degree: string
  location?: string
  start_date?: string
  end_date?: string
  details?: string
  created_at?: string
  updated_at?: string
}

// Reactive store
interface State {
  educations: Education[]
  loading: boolean
  error: string | null
  fetched: boolean
}

export const educationStore = reactive<State>({
  educations: [],
  loading: false,
  error: null,
  fetched: false
})

// Fetch education only once
export const fetchEducationsOnce = async () => {
  if (educationStore.fetched) return
  educationStore.loading = true
  educationStore.error = null

  try {
    const result = await getEducations()
    educationStore.educations = result ?? []
    educationStore.fetched = true
  } catch (err: any) {
    educationStore.error = err?.message || 'Failed to load education records'
  } finally {
    educationStore.loading = false
  }
}
