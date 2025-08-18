// src/services/types.ts

// -------------------------
// Location Related
// -------------------------
export interface Township {
  id: number
  name: string
}

export interface Ward {
  id: number
  name: string
}

// -------------------------
// User Related
// -------------------------
export interface User {
  id: number
  name: string
  email: string
  township_id?: number
  ward_id?: number
  township?: Township   // relation with Township
  ward?: Ward           // relation with Ward
  created_at?: string
  updated_at?: string
  two_factor_enabled?: boolean
}

// -------------------------
// Auth Related
// -------------------------
export interface RegisterData {
  name: string
  email: string
  password: string
  password_confirmation: string
}

export interface LoginData {
  email: string
  password: string
}

export interface AuthResponse {
  success: boolean
  message: string
  data: {
    user: User
    token: string
    token_type: string
  }
}

// -------------------------
// Blog Related
// -------------------------
export interface BlogData {
  id?: number
  title: string
  excerpt?: string
  content: string
  published_at?: string
  user_id?: number | string
}

export interface Blog {
  id: number | string
  title: string
  excerpt?: string | null
  content: string
  published_at?: string
  created_at: string
  updated_at: string
  user_id: number | string
  user?: { 
    id: number | string
    name: string 
  } | null
}

export interface BlogResponse {
  data: Blog[]
  next_page_url: string | null
}
