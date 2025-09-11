<template>
  <div 
    class="group p-6 bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 hover:shadow-xl hover:border-blue-300 dark:hover:border-blue-500 transition-all duration-300 hover:-translate-y-1 animate-fade-in-up"
    :style="{ animationDelay: `${animationDelay}ms` }"
  >
    <div class="flex items-center justify-between">
      <div>
        <p class="text-gray-600 dark:text-slate-400 text-sm font-medium uppercase tracking-wide">
          {{ stat.title }}
        </p>
        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
          {{ stat.value }}
        </p>
        <p class="text-sm text-green-600 dark:text-green-400 mt-2 flex items-center gap-1">
          <ArrowTrendingUpIcon class="w-4 h-4" />
          {{ stat.change }}
        </p>
      </div>
      <div :class="[
        'p-4 rounded-2xl group-hover:scale-110 transition-transform duration-300',
        'bg-gradient-to-br opacity-20 group-hover:opacity-30',
        stat.color
      ]">
        <component :is="stat.icon" class="w-8 h-8 text-blue-600 dark:text-blue-400" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ArrowTrendingUpIcon } from '@heroicons/vue/24/outline'
import type { StatItem } from '@/composables/useDashboardStats'

interface Props {
  stat: StatItem
  animationDelay: number
}

defineProps<Props>()
</script>

<style scoped>
@keyframes fade-in-up {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in-up {
  animation: fade-in-up 0.8s ease-out forwards;
  opacity: 0;
}
</style>