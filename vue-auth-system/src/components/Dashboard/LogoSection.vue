<template>
  <div class="flex items-center gap-2.5">
    <div class="relative w-10 h-10 bg-gradient-to-tr from-indigo-600 to-violet-500 rounded-lg flex items-center justify-center shadow-sm ring-1 ring-white/10">
      <CodeBracketIcon class="w-5 h-5 text-white" />
      <div class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-400 rounded-full animate-pulse" />
    </div>
    <div class="leading-tight">
      <h1 class="text-lg font-semibold text-white">K's Portfolio</h1>
      <p class="text-xs text-white">Portfolio Hub</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { CodeBracketIcon } from '@heroicons/vue/24/outline'
</script>