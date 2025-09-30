import { computed } from 'vue'
import {
  CodeBracketIcon,
  BriefcaseIcon,
  ChartBarIcon,
  EyeIcon,
} from '@heroicons/vue/24/outline'

export interface StatItem {
  title: string
  value: string
  change: string
  icon: any
  color: string
}

export const useDashboardStats = () => {
  const quickStats = computed<StatItem[]>(() => [
    { 
      title: 'Projects', 
      value: '6', 
      change: '+3 this month',
      icon: CodeBracketIcon,
      color: 'from-blue-500 to-blue-600'
    },
    { 
      title: 'Experience', 
      value: '4+', 
      change: 'Years',
      icon: BriefcaseIcon,
      color: 'from-purple-500 to-purple-600'
    },
    { 
      title: 'Skills', 
      value: '12', 
      change: 'Technologies',
      icon: ChartBarIcon,
      color: 'from-green-500 to-green-600'
    },
    { 
      title: 'Views', 
      value: '1.2k', 
      change: '+15% this week',
      icon: EyeIcon,
      color: 'from-orange-500 to-orange-600'
    },
  ])

  return {
    quickStats
  }
}