<template>
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
      {{ title }}
    </h1>
    <slot name="actions" />
  </div>
</template>

<script setup lang="ts">
defineProps<{
  title: string
}>()
</script>

<style scoped>
/* Optional: add bottom border or spacing if needed */
</style>
