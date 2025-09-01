<template>
  <div class="text-center">
    <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
      <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
        {{ title }}
      </span>
    </h2>
    <p class="text-xl text-white max-w-2xl mx-auto" v-if="subtitle">
      {{ subtitle }}
    </p>
  </div>
</template>

<script setup lang="ts">
interface Props {
  title: string
  subtitle?: string
}

defineProps<Props>()
</script>