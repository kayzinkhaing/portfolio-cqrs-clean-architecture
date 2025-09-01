<template>
  <div class="animate-pulse flex space-x-4">
    <!-- Dot on timeline -->
    <div class="hidden md:block w-4 h-4 rounded-full bg-gray-700 mt-1.5"></div>

    <!-- Card skeleton -->
    <div class="flex-1 space-y-4 py-4">
      <div class="h-6 bg-gray-700 rounded w-1/3"></div>
      <div class="h-4 bg-gray-600 rounded w-1/2"></div>
      <div class="h-4 bg-gray-600 rounded w-full"></div>
      <div class="h-4 bg-gray-600 rounded w-5/6"></div>
      <div class="h-4 bg-gray-600 rounded w-2/3"></div>
    </div>
  </div>
</template>

<script setup lang="ts">
// No script needed since this is purely presentational
</script>

<style scoped>
/* Optional: customize pulse animation if needed */
</style>
