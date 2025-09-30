<template>
  <aside
    :class="[
      'flex flex-col shadow-2xl transition-all duration-300 ease-out border-r',
      isCollapsed ? 'w-20' : 'w-72',
      'bg-gradient-to-b from-slate-800 to-slate-900 border-slate-700'
    ]"
  >
    <!-- Logo & Toggle -->
    <div
      class="h-20 flex items-center justify-between px-6 border-b border-slate-700/50"
    >
      <LogoSection v-if="!isCollapsed" />
      <ToggleButton @click="$emit('toggleSidebar')" />
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-2">
      <NavigationItem
        v-for="(item, index) in navItems"
        :key="item.name"
        :item="item"
        :is-active="isActiveRoute(item.path)"
        :is-collapsed="isCollapsed"
        :animation-delay="index * 100"
        @click="$emit('navigate', item.path)"
        :class="[
          isActiveRoute(item.path)
            ? 'bg-gray-200 dark:bg-gray-700 text-black dark:text-white'
            : 'text-white dark:text-white hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors duration-300'
        ]"
      />
    </nav>

    <!-- User Profile -->
    <!-- <UserProfile v-if="!isCollapsed" /> -->
  </aside>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { NavItem } from '../../composables/useNavigation'

// Components
import LogoSection from '@/components/Dashboard/LogoSection.vue'
import ToggleButton from '@/components/Dashboard/ToggleButton.vue'
import NavigationItem from '@/components/Dashboard/NavigationItem.vue'

interface Props {
  isCollapsed: boolean
  navItems: NavItem[]
  activeRoute: string
}

const props = defineProps<Props>()

const emit = defineEmits<{
  toggleSidebar: []
  navigate: [path: string]
}>()

const isActiveRoute = (path: string) => {
  if (path === '/dashboard') {
    return props.activeRoute === '/dashboard'
  }
  return props.activeRoute.startsWith(path)
}
</script>