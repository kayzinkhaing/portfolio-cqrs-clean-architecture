<template>
  <div class="mb-8 animate-fade-in">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
      Welcome back, {{ userName }}! 👋
    </h2>
    <p class="text-gray-600 dark:text-slate-400">
      Here's what's happening with your portfolio today.
    </p>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useAuthStore } from '../../stores/auth'

const auth = useAuthStore()

// Get the logged-in user's name
const userName = computed(() => auth.user?.name || 'Guest')
</script>

<style scoped>
@keyframes fade-in {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
  animation: fade-in 0.6s ease-out;
}
</style>
