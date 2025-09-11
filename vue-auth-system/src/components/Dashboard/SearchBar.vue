<template>
  <div class="relative hidden md:block">
    <input
      v-model="searchQuery"
      type="text"
      placeholder="Search..."
      class="w-64 px-4 py-2 pl-10 bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-xl 
      text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-slate-400 
      focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
      @keydown.enter="handleSearch"
    />
    <MagnifyingGlassIcon class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline'

const searchQuery = ref('')

const handleSearch = () => {
  if (searchQuery.value.trim()) {
    // Implement search functionality
    console.log('Searching for:', searchQuery.value)
  }
}
</script>