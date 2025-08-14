// src/services/types.ts

export interface User {
  id: number
  name: string
  email: string
  township_id?: number
  ward_id?: number
  created_at?: string
  updated_at?: string
}

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
  user_id: number | string
  user?: { id: number | string; name: string } | null
}

export interface BlogResponse {
  data: Blog[]
  next_page_url: string | null
}

export interface AuthResponse {
  user: User
  token: string
  token_type: string
}
