import axios from 'axios'
import { ROUTES } from '../routes'

export interface Technology {
  id: number
  name: string
  created_at: string
  updated_at: string
}

export async function getTechnologies(): Promise<Technology[]> {
  try {
    const { data } = await axios.get(ROUTES.technologies.list)
    return Array.isArray(data.data) ? data.data : []
  } catch (err) {
    console.error('Error fetching technologies:', err)
    return []
  }
}
