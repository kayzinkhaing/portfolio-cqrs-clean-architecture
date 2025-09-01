<!-- src/components/portfolio/SkillItem.vue -->
<template>
  <div class="bg-gray-800/30 rounded-lg p-4 border border-gray-700/50 hover:border-gray-600 transition-all duration-300 group">
    <div class="flex items-center justify-between mb-3">
      <div class="flex items-center">
        <div :class="colorClasses[color]" class="w-3 h-3 rounded-full mr-3"></div>
        <h4 class="text-white font-semibold group-hover:text-indigo-400 transition-colors">
          {{ name }}
        </h4>
      </div>
      <div class="text-right">
        <div class="text-sm font-semibold text-white">{{ level }}%</div>
        <div class="text-xs text-gray-400">{{ experienceLevel }}</div>
      </div>
    </div>

    <!-- Progress Bar -->
    <div class="mb-3">
      <div class="w-full bg-gray-700 rounded-full h-2 overflow-hidden">
        <div 
          :class="colorClasses[color]"
          class="h-full rounded-full transition-all duration-1000 ease-out"
          :style="{ width: `${level}%` }"
        ></div>
      </div>
    </div>

    <!-- Experience & Certification -->
    <div class="flex items-center justify-between text-xs">
      <span class="text-gray-400">{{ experience }}</span>
      <span 
        v-if="certification" 
        class="px-2 py-1 bg-indigo-900/50 text-indigo-300 rounded"
      >
        {{ certification }}
      </span>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

interface Props {
  name: string
  level: number
  experience: string
  color: string
  certification?: string
}

const props = defineProps<Props>()

const experienceLevel = computed(() => {
  if (props.level >= 90) return 'Expert'
  if (props.level >= 75) return 'Advanced'  
  if (props.level >= 60) return 'Intermediate'
  return 'Beginner'
})

const colorClasses: Record<string, string> = {
  green: 'bg-green-500',
  blue: 'bg-blue-500', 
  purple: 'bg-purple-500',
  yellow: 'bg-yellow-500',
  cyan: 'bg-cyan-500',
  pink: 'bg-pink-500',
  orange: 'bg-orange-500',
  red: 'bg-red-500',
  indigo: 'bg-indigo-500',
  gray: 'bg-gray-500'
}
</script>