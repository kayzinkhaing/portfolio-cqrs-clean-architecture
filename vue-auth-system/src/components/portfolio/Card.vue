<template>
  <div class="p-4 border rounded-lg shadow hover:shadow-lg transition">
    <h3 class="font-semibold text-xl mb-2">{{ title }}</h3>
    <p class="text-gray-600 mb-2">{{ description }}</p>
    <a v-if="link" :href="link" target="_blank" class="text-indigo-600 hover:underline">View</a>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  title: string;
  description: string;
  link?: string;
}>();
</script>
