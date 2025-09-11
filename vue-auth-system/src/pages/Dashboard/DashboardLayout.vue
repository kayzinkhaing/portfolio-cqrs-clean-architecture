<template>
  <div :class="[
    'flex h-screen',
    isDark ? 'dark bg-slate-900' : 'bg-gray-50'
  ]">
    <!-- Sidebar -->
    <SidebarComponent
      :is-collapsed="isCollapsed"
      :nav-items="navItems"
      :active-route="$route.path"
      @toggle-sidebar="toggleSidebar"
      @navigate="handleNavigation"
    />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
      <!-- Header -->
      <HeaderComponent
        :is-dark="isDark"
        :show-profile-menu="showProfileMenu"
        @toggle-dark-mode="toggleDarkMode"
        @toggle-profile-menu="toggleProfileMenu"
        @logout="handleLogout"
      />

      <!-- Content Area -->
      <MainContentComponent>
        <!-- Route-specific content will be rendered here -->
        <RouterView />
      </MainContentComponent>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useDarkMode } from '@/composables/useDarkMode'
import { useNavigation } from '@/composables/useNavigation'

// Components
import SidebarComponent from '@/components/Dashboard/SidebarComponent.vue'
import HeaderComponent from '@/components/Dashboard/HeaderComponent.vue'
import MainContentComponent from '@/components/Dashboard/MainContentComponent.vue'

// Composables
const router = useRouter()
const route = useRoute()
const { isDark, toggleDarkMode } = useDarkMode()
const { navItems } = useNavigation()

// Reactive state
const isCollapsed = ref(false)
const showProfileMenu = ref(false)

// Methods
const toggleSidebar = () => {
  isCollapsed.value = !isCollapsed.value
}

const toggleProfileMenu = () => {
  showProfileMenu.value = !showProfileMenu.value
}

const handleNavigation = (path: string) => {
  router.push(path)
}

const handleLogout = () => {
  // Add your logout logic here
  router.push('/home/login')
}

// Close dropdown when clicking outside
const handleClickOutside = (event: Event) => {
  const target = event.target as Element
  if (!target?.closest('.profile-dropdown')) {
    showProfileMenu.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<style scoped>
/* Component-specific styles if needed */
</style>