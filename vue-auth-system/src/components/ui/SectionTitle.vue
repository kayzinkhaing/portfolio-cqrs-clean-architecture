<template>
  <div class="text-center mb-12 relative">
    <!-- Title -->
    <h2
      class="text-3xl md:text-5xl font-bold text-white tracking-tight inline-block relative"
    >
      <span
        class="bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent"
      >
        {{ title }}
      </span>
      <!-- Gradient underline -->
      <span
        class="block mx-auto mt-2 w-16 h-1 bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 rounded-full"
      ></span>
    </h2>

    <!-- Subtitle -->
    <p
      v-if="subtitle"
      class="mt-4 text-base md:text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed"
    >
      {{ subtitle }}
    </p>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  title: string
  subtitle?: string
}>()
</script>
