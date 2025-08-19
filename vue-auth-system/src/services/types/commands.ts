// src/services/types/commands.ts

// Blog Write DTO
export interface BlogCreateCommand {
  title: string
  content: string
  excerpt?: string
  published_at?: string
  user_id?: number | string
}

export interface BlogUpdateCommand {
  title?: string
  content?: string
  excerpt?: string
  published_at?: string
}

// User Write DTO
export interface UserUpdateCommand {
  name?: string
  email?: string
  township_id?: number
  ward_id?: number
  password?: string
  two_factor_enabled?: boolean
}
