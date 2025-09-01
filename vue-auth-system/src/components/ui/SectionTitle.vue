<template>
  <div class="text-center mb-12">
    <h2 class="text-4xl font-bold text-white">{{ title }}</h2>
    <p v-if="subtitle" class="mt-2 text-lg text-gray-300">{{ subtitle }}</p>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  title: string
  subtitle?: string
  class?: string
}>()
</script>

<style scoped>
/* optional custom styling */
</style>
