<template>
  <header class="h-20 flex items-center justify-between px-8 bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 shadow-sm">
    <!-- Left Section -->
    <div class="flex items-center gap-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
          {{ pageTitle }}
        </h1>
        <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">
          {{ pageSubtitle }}
        </p>
      </div>
    </div>

    <!-- Right Section -->
    <div class="flex items-center gap-4">
      <!-- Search Bar -->
      <SearchBar />
      
      <!-- Notifications -->
      <NotificationButton />
      
      <!-- Dark Mode Toggle -->
      <!-- <DarkModeToggle 
        :is-dark="isDark" 
        @toggle="$emit('toggleDarkMode')" 
      /> -->
      
      <!-- Profile Dropdown -->
      <ProfileDropdown 
        :show="showProfileMenu"
        @toggle="$emit('toggleProfileMenu')"
        @logout="$emit('logout')"
      />
    </div>
  </header>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'

// Components
import SearchBar from './SearchBar.vue'
import NotificationButton from './NotificationButton.vue'
import DarkModeToggle from './DarkModeToggle.vue'
import ProfileDropdown from './ProfileDropdown.vue'

interface Props {
  isDark: boolean
  showProfileMenu: boolean
}

defineProps<Props>()

const emit = defineEmits<{
  toggleDarkMode: []
  toggleProfileMenu: []
  logout: []
}>()

const route = useRoute()

const pageTitle = computed(() => {
  const routeMap: Record<string, string> = {
    '/dashboard': 'Dashboard',
    '/dashboard/projects': 'Projects',
    '/dashboard/experience': 'Experience',
    '/dashboard/education': 'Education',
    '/dashboard/hire-me': 'Hire Me',
    '/dashboard/settings': 'Settings'
  }
  return routeMap[route.path] || 'Dashboard'
})

const pageSubtitle = computed(() => {
  const subtitleMap: Record<string, string> = {
    '/dashboard': 'Manage your portfolio and projects',
    '/dashboard/projects': 'Manage your project portfolio',
    '/dashboard/experience': 'Track your work experience',
    '/dashboard/education': 'Manage your educational background',
    '/dashboard/hire-me': 'Handle hiring requests and inquiries',
    '/dashboard/settings': 'Configure your account settings'
  }
  return subtitleMap[route.path] || 'Manage your portfolio'
})
</script>