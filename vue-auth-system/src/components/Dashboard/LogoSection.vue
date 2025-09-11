<template>
  <div class="flex items-center gap-3 animate-fade-in">
    <div class="relative">
      <div class="w-11 h-11 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg">
        <CodeBracketIcon class="w-6 h-6 text-white" />
      </div>
      <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-400 rounded-full border-2 border-slate-800 animate-pulse"></div>
    </div>
    <div>
      <span class="text-xl font-bold text-white tracking-wide">
        K's Portfolio
      </span>
      <div class="text-xs text-blue-300 font-medium">Portfolio Hub</div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { CodeBracketIcon } from '@heroicons/vue/24/outline'
</script>

<style scoped>
@keyframes fade-in {
  from { opacity: 0; }
  to { opacity: 1; }
}

.animate-fade-in {
  animation: fade-in 0.6s ease-out;
}
</style>