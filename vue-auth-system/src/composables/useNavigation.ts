import { computed } from 'vue'
import {
  HomeIcon,
  CodeBracketIcon,
  BriefcaseIcon,
  AcademicCapIcon,
  EyeIcon,
  Cog6ToothIcon,
} from '@heroicons/vue/24/outline'

export interface NavItem {
  name: string
  path: string
  icon: any
  badge?: string
}

export const useNavigation = () => {
  const navItems = computed<NavItem[]>(() => [
    { 
      name: 'Overview', 
      path: '/dashboard', 
      icon: HomeIcon 
    },
    { 
      name: 'Projects', 
      path: '/dashboard/projects', 
      icon: CodeBracketIcon 
    },
    { 
      name: 'Experience', 
      path: '/dashboard/experience', 
      icon: BriefcaseIcon 
    },
    { 
      name: 'Education', 
      path: '/dashboard/education', 
      icon: AcademicCapIcon 
    },
    { 
      name: 'Hire Me', 
      path: '/dashboard/hire-me', 
      icon: EyeIcon 
    },
    { 
      name: 'Settings', 
      path: '/dashboard/settings', 
      icon: Cog6ToothIcon 
    },
  ])

  const isActive = (currentPath: string, itemPath: string): boolean => {
    if (itemPath === '/dashboard') {
      return currentPath === '/dashboard'
    }
    return currentPath.startsWith(itemPath)
  }

  return {
    navItems,
    isActive
  }
}