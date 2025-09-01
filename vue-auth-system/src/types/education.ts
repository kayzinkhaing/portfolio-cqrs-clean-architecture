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
