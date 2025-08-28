import type { Project } from '@/types/project'

export const getProjectImage = (project: Project): string => {
  const placeholderImages = [
    'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=400&h=300&fit=crop&crop=entropy&cs=tinysrgb',
    'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=300&fit=crop&crop=entropy&cs=tinysrgb',
    'https://images.unsplash.com/photo-1504639725590-34d0984388bd?w=400&h=300&fit=crop&crop=entropy&cs=tinysrgb',
    'https://images.unsplash.com/photo-1517180102446-f3ece451e9d8?w=400&h=300&fit=crop&crop=entropy&cs=tinysrgb',
    'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=400&h=300&fit=crop&crop=entropy&cs=tinysrgb'
  ]
  return placeholderImages[project.id % placeholderImages.length]
}

export const getStatusBadgeClass = (status?: string): string => {
  const statusClasses: Record<string, string> = {
    'Completed': 'bg-green-500/20 text-green-300 border border-green-500/30',
    'In Progress': 'bg-blue-500/20 text-blue-300 border border-blue-500/30',
    'Planning': 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30',
    'On Hold': 'bg-orange-500/20 text-orange-300 border border-orange-500/30',
    'Active': 'bg-indigo-500/20 text-indigo-300 border border-indigo-500/30'
  }
  return statusClasses[status || 'Active'] || statusClasses['Active']
}

export const formatDate = (dateString: string): string => {
  if (!dateString) return 'Ongoing'
  try {
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' })
  } catch {
    return dateString
  }
}
