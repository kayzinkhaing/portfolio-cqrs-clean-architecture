<template>
  <div class="glass-card p-4 group hover:scale-105 transition-all duration-300 cursor-pointer">
    <!-- Skill Name & Level -->
    <div class="flex items-center justify-between mb-3">
      <h4 class="font-semibold text-white text-sm">{{ name }}</h4>
      <span class="text-white text-xs">{{ level }}%</span>
    </div>

    <!-- Progress Bar -->
    <div class="w-full bg-slate-700 rounded-full h-2">
      <div 
        class="h-2 rounded-full transition-all duration-1000 ease-out"
        :class="progressColorClass"
        :style="`width: ${level}%`"
      ></div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

interface Props {
  name: string
  level: number
  color: string
}

const props = defineProps<Props>()

// Progress bar color classes
const colorClasses = {
  blue: 'bg-gradient-to-r from-blue-500 to-blue-400',
  green: 'bg-gradient-to-r from-green-500 to-green-400',
  purple: 'bg-gradient-to-r from-purple-500 to-purple-400',
  red: 'bg-gradient-to-r from-red-500 to-red-400',
  yellow: 'bg-gradient-to-r from-yellow-500 to-yellow-400',
  indigo: 'bg-gradient-to-r from-indigo-500 to-indigo-400',
  pink: 'bg-gradient-to-r from-pink-500 to-pink-400',
  cyan: 'bg-gradient-to-r from-cyan-500 to-cyan-400',
  orange: 'bg-gradient-to-r from-orange-500 to-orange-400',
  gray: 'bg-gradient-to-r from-gray-500 to-gray-400'
}

const progressColorClass = computed(() => colorClasses[props.color as keyof typeof colorClasses] || colorClasses.blue)
</script>

<style scoped>
.glass-card {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 1rem;
}
</style>
