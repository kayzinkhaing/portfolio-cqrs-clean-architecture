<template>
  <div class="relative">
    <!-- Timeline Dot -->
    <div 
      class="absolute left-6 w-4 h-4 rounded-full border-4 border-slate-900 hidden md:block"
      :class="highlight ? 'bg-gradient-to-r from-indigo-500 to-purple-600' : 'bg-slate-600'"
    ></div>
    
    <!-- Content -->
    <div class="md:ml-20">
      <div class="glass-card p-8">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-4">
          <div>
            <h3 class="text-2xl font-bold text-white mb-2">{{ title }}</h3>
            <h4 class="text-lg text-indigo-400 mb-2">{{ subtitle }}</h4>
          </div>
          <div class="mt-4 lg:mt-0">
            <span 
              class="inline-block px-4 py-2 rounded-full text-sm font-semibold"
              :class="highlight ? 'bg-indigo-500/20 text-indigo-400' : 'bg-slate-700 text-slate-300'"
            >
              {{ year }}
            </span>
          </div>
        </div>
        
        <!-- Content Slot -->
        <div class="text-slate-300">
          <slot></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Props {
  title: string
  subtitle: string
  year: string
  highlight?: boolean
}

defineProps<Props>()
</script>