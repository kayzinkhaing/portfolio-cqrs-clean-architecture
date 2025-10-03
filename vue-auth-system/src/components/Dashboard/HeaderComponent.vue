<template>
  <header class="h-20 flex items-center justify-between px-8 bg-white border-b border-gray-200 shadow-sm">
    <div class="flex items-center gap-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ pageTitle }}</h1>
        <p class="text-sm text-gray-600 mt-1">{{ pageSubtitle }}</p>
      </div>
    </div>

    <div class="flex items-center gap-4">
      <SearchBar />
      <NotificationButton />
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
import SearchBar from './SearchBar.vue'
import NotificationButton from './NotificationButton.vue'
import ProfileDropdown from './ProfileDropdown.vue'

interface Props {
  showProfileMenu: boolean
}

defineProps<Props>()

const emit = defineEmits<{
  toggleProfileMenu: []
  logout: []
}>()

const route = useRoute()

const pageTitle = computed(() => {
  const map: Record<string, string> = {
    '/dashboard': 'Dashboard',
    '/dashboard/projects': 'Projects',
    '/dashboard/experience': 'Experience',
    '/dashboard/education': 'Education',
    '/dashboard/hire-me': 'Hire Me',
    '/dashboard/settings': 'Settings'
  }
  return map[route.path] || 'Dashboard'
})

const pageSubtitle = computed(() => {
  const map: Record<string, string> = {
    '/dashboard': 'Manage your portfolio and projects',
    '/dashboard/projects': 'Manage your project portfolio',
    '/dashboard/experience': 'Track your work experience',
    '/dashboard/education': 'Manage your educational background',
    '/dashboard/hire-me': 'Handle hiring requests and inquiries',
    '/dashboard/settings': 'Configure your account settings'
  }
  return map[route.path] || 'Manage your portfolio'
})
</script>
