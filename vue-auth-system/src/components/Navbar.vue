<template>
  <nav class="bg-white shadow-md px-6 py-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
      <!-- Logo -->
      <router-link to="/"
        class="text-2xl font-extrabold bg-gradient-to-r from-indigo-500 to-indigo-700 text-transparent bg-clip-text hover:from-indigo-600 hover:to-indigo-800 transition duration-300">
        MyBlog
      </router-link>
  
      <!-- Menu -->
      <div class="flex items-center space-x-6 relative">
        <!-- Authenticated -->
        <AuthenticatedMenu v-if="isAuthenticated" :user="auth.user" @logout="handleLogout" />
  
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
import AuthenticatedMenu from '@/Navbar/AuthenticatedMenu.vue'
import GuestMenu from '@/Navbar/GuestMenu.vue'

const auth = useAuthStore()
const router = useRouter()

const isAuthenticated = computed(
  () => auth.initialized && auth.isAuthenticated
)

const handleLogout = async () => {
  await auth.logoutUser()
  router.push('/login')
}
</script>
