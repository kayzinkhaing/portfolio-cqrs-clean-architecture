<!-- src/components/portfolio/SkillCard.vue -->
<template>
  <div class="skill-card group cursor-pointer" @click="showDetails = !showDetails">
    <!-- Main Skill Display -->
    <div class="relative p-4 rounded-lg bg-gray-800/50 border border-gray-700 hover:border-gray-600 transition-all duration-300">
      <!-- Skill Icon & Name -->
      <div class="text-center mb-3">
        <div class="text-3xl mb-2 group-hover:scale-110 transition-transform">{{ icon }}</div>
        <h4 class="text-white font-semibold text-sm group-hover:text-indigo-400 transition-colors">{{ name }}</h4>
      </div>

      <!-- Circular Progress -->
      <div class="relative w-16 h-16 mx-auto mb-3">
        <svg class="w-16 h-16 transform -rotate-90" viewBox="0 0 36 36">
          <!-- Background circle -->
          <path
            d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
            fill="none"
            stroke="#374151"
            stroke-width="2"
          />
          <!-- Progress circle -->
          <path
            d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
            fill="none"
            :stroke="strokeColor"
            stroke-width="2"
            stroke-linecap="round"
            :stroke-dasharray="`${level} ${100 - level}`"
            class="transition-all duration-1000 ease-out"
          />
        </svg>
        <!-- Percentage in center -->
        <div class="absolute inset-0 flex items-center justify-center">
          <span class="text-xs font-bold text-white">{{ level }}%</span>
        </div>
      </div>

      <!-- Experience & Projects -->
      <div class="text-center">
        <div class="text-xs text-gray-400 mb-1">{{ experience }}</div>
        <div v-if="projects" class="text-xs text-gray-500">{{ projects }} projects</div>
      </div>

      <!-- Proficiency Level Badge -->
      <div class="absolute top-2 right-2">
        <span 
          :class="levelBadgeClass"
          class="px-2 py-1 text-xs font-medium rounded-full"
        >
          {{ proficiencyLevel }}
        </span>
      </div>
    </div>

    <!-- Detailed View (Expandable) -->
    <Transition name="slide-fade">
      <div v-if="showDetails" class="mt-2 p-3 bg-gray-900/80 rounded-lg border border-gray-600">
        <h5 class="text-white font-medium mb-2">Experience Details</h5>
        <div class="space-y-1 text-xs text-gray-300">
          <div>• {{ getExperienceDetail() }}</div>
          <div>• {{ getProjectDetail() }}</div>
          <div>• {{ getProficiencyDetail() }}</div>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

interface Props {
  name: string
  level: number
  icon: string
  color: string
  experience: string
  projects?: number
}

const props = defineProps<Props>()
const showDetails = ref(false)

const strokeColor = computed(() => {
  const colors: Record<string, string> = {
    orange: '#f97316',
    blue: '#3b82f6',
    yellow: '#eab308',
    green: '#22c55e',
    cyan: '#06b6d4',
    purple: '#a855f7',
    red: '#ef4444',
    pink: '#ec4899',
    indigo: '#6366f1',
    gray: '#6b7280'
  }
  return colors[props.color] || '#6366f1'
})

const proficiencyLevel = computed(() => {
  if (props.level >= 90) return 'Expert'
  if (props.level >= 75) return 'Advanced'
  if (props.level >= 60) return 'Intermediate'
  return 'Beginner'
})

const levelBadgeClass = computed(() => {
  if (props.level >= 90) return 'bg-green-500/20 text-green-300'
  if (props.level >= 75) return 'bg-blue-500/20 text-blue-300'
  if (props.level >= 60) return 'bg-yellow-500/20 text-yellow-300'
  return 'bg-gray-500/20 text-gray-300'
})

const getExperienceDetail = () => {
  const exp = props.experience
  if (exp.includes('3+')) return 'Extensive hands-on experience with production applications'
  if (exp.includes('2+')) return 'Solid experience building real-world projects'
  if (exp.includes('1+')) return 'Growing expertise with practical application'
  return 'Learning and applying in personal projects'
}

const getProjectDetail = () => {
  if (!props.projects) return 'Applied in various development contexts'
  if (props.projects >= 15) return `Used extensively across ${props.projects}+ projects`
  if (props.projects >= 10) return `Core technology in ${props.projects}+ projects`
  if (props.projects >= 5) return `Implemented in ${props.projects}+ projects`
  return `Practical experience in ${props.projects}+ projects`
}

const getProficiencyDetail = () => {
  if (props.level >= 90) return 'Can mentor others and architect complex solutions'
  if (props.level >= 75) return 'Comfortable with advanced features and best practices'
  if (props.level >= 60) return 'Solid understanding with room for growth'
  return 'Basic proficiency, actively learning'
}
</script>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.3s ease;
}

.slide-fade-enter-from {
  opacity: 0;
  transform: translateY(-10px);
}

.slide-fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>