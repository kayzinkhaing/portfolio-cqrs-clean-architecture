// src/types/education.ts

export interface Education {
  id: number | string
  user_id: number | string
  institution: string
  degree: string
  location: string
  start_date: string
  end_date: string | null
  is_current: boolean
  details: string
  created_at: string
  updated_at: string
}

// Form data (used for create/update commands)
export interface EducationFormData {
  institution: string
  degree: string
  location: string
  start_date: string
  end_date: string | null
  is_current?: boolean
  details: string
}
