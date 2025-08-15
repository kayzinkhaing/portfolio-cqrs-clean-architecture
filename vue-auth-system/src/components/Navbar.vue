<template> 
  <nav class="bg-white/80 backdrop-blur-xl border-b border-gray-200/50 px-6 py-4 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
      <!-- Logo with glassmorphism effect -->
      <router-link
        to="/"
        class="relative group"
      >
        <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl blur opacity-30 group-hover:opacity-50 transition duration-300"></div>
        <div class="relative px-4 py-2 bg-white rounded-xl border border-gray-200/50 shadow-lg">
          <span class="text-2xl font-bold bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 text-transparent bg-clip-text">
            MyBlog
          </span>
        </div>
      </router-link>

      <!-- Menu with modern styling -->
      <div class="flex items-center space-x-4 relative">
        <!-- Authenticated -->
        <template v-if="isAuthenticated">
          <!-- User greeting with subtle animation -->
          <div class="flex items-center space-x-3 px-4 py-2 bg-gray-50 rounded-full border border-gray-200/50">
            <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center shadow-md">
              <span class="text-white font-semibold text-sm">{{ auth.user?.name?.charAt(0).toUpperCase() }}</span>
            </div>
            <span class="text-gray-700 font-medium">{{ auth.user?.name }}</span>
          </div>
          
          <!-- Settings button with hover effects -->
          <router-link
            to="settings/info"
            class="relative group px-6 py-2.5 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-full font-medium transition-all duration-300 hover:shadow-lg hover:shadow-purple-500/25 hover:-translate-y-0.5"
          >
            <span class="relative z-10">Settings</span>
            <div class="absolute inset-0 bg-gradient-to-r from-purple-700 to-pink-700 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          </router-link>
        </template>

        <!-- Guest -->
        <GuestMenu v-else-if="auth.initialized" />
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'
import GuestMenu from '../Navbar/GuestMenu.vue'

const auth = useAuthStore()
const router = useRouter()

const isAuthenticated = computed(
  () => auth.initialized && auth.isAuthenticated
)
</script>