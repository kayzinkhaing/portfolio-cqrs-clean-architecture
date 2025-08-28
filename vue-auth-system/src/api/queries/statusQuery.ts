import axios from 'axios'
import { ROUTES } from '../routes'

export interface Status {
  id: number
  name: string
  created_at: string
  updated_at: string
}

export async function getStatuses(): Promise<Status[]> {
  try {
    const { data } = await axios.get(ROUTES.statuses.list)
    return Array.isArray(data.data) ? data.data : []
  } catch (err) {
    console.error('Error fetching statuses:', err)
    return []
  }
}
