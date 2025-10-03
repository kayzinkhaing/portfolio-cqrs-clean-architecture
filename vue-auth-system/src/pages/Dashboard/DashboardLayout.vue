<template>
  <div class="flex h-screen">
    <!-- Sidebar -->
    <SidebarComponent
      :is-collapsed="isCollapsed"
      :nav-items="navItems"
      :active-route="$route.path"
      @toggle-sidebar="toggleSidebar"
      @navigate="handleNavigation"
    />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Header -->
      <HeaderComponent
        :show-profile-menu="showProfileMenu"
        @toggle-profile-menu="toggleProfileMenu"
        @logout="handleLogout"
      />

      <!-- Page Content -->
      <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
        <div class="max-w-7xl mx-auto">
          <RouterView />
        </div>
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useNavigation } from '@/composables/useNavigation'

import SidebarComponent from '@/components/Dashboard/SidebarComponent.vue'
import HeaderComponent from '@/components/Dashboard/HeaderComponent.vue'

const router = useRouter()
const route = useRoute()
const { navItems } = useNavigation()

const isCollapsed = ref(false)
const showProfileMenu = ref(false)

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
  router.push('/home/login')
}

const handleClickOutside = (event: Event) => {
  const target = event.target as Element
  if (!target?.closest('.profile-dropdown')) {
    showProfileMenu.value = false
  }
}

onMounted(() => document.addEventListener('click', handleClickOutside))
onUnmounted(() => document.removeEventListener('click', handleClickOutside))
</script>
