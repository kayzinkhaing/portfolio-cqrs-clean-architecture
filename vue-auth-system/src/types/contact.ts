// src/api/types.ts

export interface ContactMessage {
  id: number
  name: string
  email: string
  subject?: string | null
  message: string
  is_read: boolean
  created_at: string
  updated_at: string
}

export interface ContactMessageData {
  name: string
  email: string
  subject?: string | null
  message: string
}
