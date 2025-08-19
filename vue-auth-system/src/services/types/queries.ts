// src/services/types/queries.ts

// Blog Read Model
export interface BlogReadModel {
  id: number | string
  title: string
  excerpt?: string | null
  content: string
  published_at?: string
  created_at: string
  updated_at: string
  user: {
    id: number | string
    name: string
  }
}

// Blogs List Response
export interface BlogsQueryResponse {
  data: BlogReadModel[]
  next_page_url: string | null
  total?: number
}

// User Read Model
export interface UserReadModel {
  id: number
  name: string
  email: string
  township?: { id: number; name: string }
  ward?: { id: number; name: string }
  created_at: string
  updated_at: string
  two_factor_enabled?: boolean
}

// Auth Read Model
export interface AuthQueryResponse {
  success: boolean
  message: string
  data: {
    user: UserReadModel
    token: string
    token_type: string
  }
}
