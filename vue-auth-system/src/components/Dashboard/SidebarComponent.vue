<template>
  <aside
    :class="[
      'flex flex-col transition-all duration-300 ease-out border-r shadow-lg',
      isCollapsed ? 'w-20' : 'w-72',
      'bg-gray-900 border-gray-800'
    ]"
  >
    <!-- Logo & Toggle -->
    <div class="h-20 flex items-center justify-between px-6 border-b border-gray-800/50">
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
            ? 'bg-gray-800 text-white'
            : 'text-white hover:bg-gray-700 transition-colors duration-300'
        ]"
      />
    </nav>
  </aside>
</template>

<script setup lang="ts">
import type { NavItem } from '@/composables/useNavigation'
import LogoSection from './LogoSection.vue'
import ToggleButton from './ToggleButton.vue'
import NavigationItem from './NavigationItem.vue'

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
  if (path === '/dashboard') return props.activeRoute === '/dashboard'
  return props.activeRoute.startsWith(path)
}
</script>
