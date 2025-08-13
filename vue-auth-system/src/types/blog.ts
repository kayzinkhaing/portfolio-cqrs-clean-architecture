// src/types/blog.ts
export interface Blog {
  id: number
  title: string
  content: string
  created_at: string
  updated_at: string
  user?: {
    id: number
    name: string
  }
}
