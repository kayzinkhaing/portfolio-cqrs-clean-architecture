<template>
  <div class="flex justify-between items-center p-4">
    <button @click="$emit('change-page', currentPage-1)" :disabled="currentPage===1">Prev</button>
    <span>Page {{ currentPage }} of {{ totalPages }}</span>
    <button @click="$emit('change-page', currentPage+1)" :disabled="currentPage===totalPages">Next</button>
  </div>
</template>

<script setup lang="ts">
defineProps<{ currentPage: number; totalPages: number }>()
</script>
