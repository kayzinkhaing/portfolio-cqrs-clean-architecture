<template>
  <div class="glass-card p-8">
    <!-- Card Header -->
    <h4 class="text-xl font-bold text-white mb-6 flex items-center">
      <span
        class="w-6 h-6 rounded mr-3"
        :class="`bg-gradient-to-r ${iconGradient}`"
      ></span>
      {{ title }}
    </h4>

    <!-- Items List -->
    <ul class="space-y-3 text-white">
      <li v-for="(item, index) in items" :key="index" class="flex items-start">
        <span class="text-indigo-400 mr-3">▸</span>
        {{ item }}
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue'

const props = defineProps<{
  title: string
  iconGradient: string
  items: string[]
}>()
</script>

<style scoped>
/* Optional: add hover or transition effects */
</style>
