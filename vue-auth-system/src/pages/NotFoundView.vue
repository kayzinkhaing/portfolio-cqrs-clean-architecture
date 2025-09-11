<!-- src/pages/NotFoundView.vue -->
<template>
  <div class="min-h-screen bg-gray-50 dark:bg-slate-900 flex items-center justify-center px-4">
    <div class="text-center">
      <div class="mb-8">
        <h1 class="text-9xl font-bold text-gray-300 dark:text-slate-600">404</h1>
        <div class="absolute inset-0 flex items-center justify-center">
          <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center animate-pulse">
            <ExclamationTriangleIcon class="w-12 h-12 text-white" />
          </div>
        </div>
      </div>
      
      <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
        Page Not Found
      </h2>
      
      <p class="text-gray-600 dark:text-slate-400 mb-8 max-w-md mx-auto">
        Sorry, we couldn't find the page you're looking for. The page might have been moved, deleted, or you entered the wrong URL.
      </p>
      
      <div class="space-y-4">
        <RouterLink
          to="/dashboard"
          class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
        >
          <HomeIcon class="w-5 h-5" />
          Go to Dashboard
        </RouterLink>
        
        <div class="text-center">
          <button
            @click="goBack"
            class="text-gray-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
          >
            ← Go back to previous page
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'
import { HomeIcon, ExclamationTriangleIcon } from '@heroicons/vue/24/outline'

const router = useRouter()

const goBack = () => {
  if (window.history.length > 1) {
    router.go(-1)
  } else {
    router.push('/dashboard')
  }
}
</script>