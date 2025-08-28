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
