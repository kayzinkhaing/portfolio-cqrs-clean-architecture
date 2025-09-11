export interface Technology {
  id: number
  name: string
  icon?: string
}

export interface Status {
  id: number
  name: string
}

export interface Project {
  id: number
  title: string
  description: string
  status?: Status
  start_date: string
  end_date: string
  is_featured: boolean
  technologies: Technology[]
}
export interface ProjectCreateInput {
  title: string
  description: string
  status_id: number
  technology_ids?: number[]
  image_url?: string | null
}

export interface ProjectUpdateInput {
  title?: string
  description?: string
  status_id?: number
  technology_ids?: number[]
}

export interface ProjectFormData {
  title: string
  description: string
  status_id: number | string 
  technology_ids: number[]
  start_date: string
  end_date: string
  is_featured: boolean
}

export interface ValidationErrors {
  title: string
  description: string
  status_id: string
  [key: string]: string
}