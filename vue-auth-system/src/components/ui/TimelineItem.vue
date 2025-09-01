<template>
  <div class="relative pl-12">
    <!-- Marker -->
    <div 
      class="absolute left-0 top-1 w-6 h-6 rounded-full border-2 border-indigo-500"
      :class="highlight ? 'bg-indigo-500' : 'bg-gray-800'"
    ></div>

    <!-- Content -->
    <div class="ml-4">
      <div class="flex justify-between items-center mb-2">
        <span class="font-semibold text-indigo-400">{{ year }}</span>
      </div>
      <h3 class="text-xl font-bold text-white">{{ title }}</h3>
      <h4 v-if="subtitle" class="text-md text-gray-300">{{ subtitle }}</h4>
      <div class="mt-2">
        <slot></slot> <!-- dynamic content like description, key subjects -->
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  year: string
  title: string
  subtitle?: string
  highlight?: boolean
}>()
</script>

<style scoped>
/* optional animation or gradient for timeline line */
</style>
