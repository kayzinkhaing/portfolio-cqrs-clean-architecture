// -------------------------
//C:\xampp\htdocs\vue-testing-project\vue-auth-system\src\api\types.ts
// Location Related
// -------------------------
// src/api/types.ts (UPDATED)
export interface Township {
  id: string
  name: string
}

export interface Ward {
  id: string
  name: string
  township_id?: string
}

export interface User {
  id: string
  name: string
  email: string
  township_id?: string
  ward_id?: string
  township?: Township | null
  ward?: Ward | null
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
    access_token: string
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
  user?: { id: number | string; name: string } | null
}

export interface BlogResponse {
  data: Blog[]
  next_page_url: string | null
}
