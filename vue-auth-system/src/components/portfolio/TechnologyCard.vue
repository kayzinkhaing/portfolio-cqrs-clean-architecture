<!-- src/components/portfolio/TechCard.vue -->
<template>
  <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700 hover:border-gray-600 transition-all duration-300 group">
    <div class="flex items-start justify-between mb-4">
      <div>
        <h4 class="text-lg font-bold text-white group-hover:text-indigo-400 transition-colors">
          {{ name }}
        </h4>
        <span class="text-sm text-gray-400">{{ version }}</span>
      </div>
      <div :class="colorClasses[color]" class="w-3 h-3 rounded-full flex-shrink-0"></div>
    </div>
    
    <p class="text-gray-300 text-sm mb-4 leading-relaxed">
      {{ purpose }}
    </p>
    
    <div class="space-y-2">
      <h5 class="text-sm font-semibold text-gray-400 uppercase tracking-wide">Key Features</h5>
      <ul class="space-y-1">
        <li 
          v-for="feature in features" 
          :key="feature"
          class="text-gray-300 text-sm flex items-center"
        >
          <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full mr-2 flex-shrink-0"></span>
          {{ feature }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Props {
  name: string
  version: string
  purpose: string
  features: string[]
  color: string
}

defineProps<Props>()

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