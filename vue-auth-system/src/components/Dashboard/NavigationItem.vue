<template>
  <button
    :class="[
      'group flex items-center gap-4 w-full px-4 py-3 rounded-xl',
      'transition-all duration-300 text-left',
      isActive
        ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg transform scale-105'
        : 'text-slate-300 hover:bg-slate-700/50 hover:text-blue-400'
    ]"
    :style="{ animationDelay: `${animationDelay}ms` }"
    @click="$emit('click')"
  >
    <component
      :is="item.icon"
      :class="[
        'w-5 h-5 transition-all duration-300',
        isActive ? 'text-white' : 'text-slate-400 group-hover:text-blue-400'
      ]"
    />
    <span 
      v-if="!isCollapsed" 
      class="font-medium transition-all duration-300"
    >
      {{ item.name }}
    </span>
    <span
      v-if="item.badge && !isCollapsed"
      class="ml-auto px-2 py-1 text-xs bg-red-500 text-white rounded-full"
    >
      {{ item.badge }}
    </span>
  </button>
</template>

<script setup lang="ts">
import type { NavItem } from '@/composables/useNavigation'

interface Props {
  item: NavItem
  isActive: boolean
  isCollapsed: boolean
  animationDelay: number
}

defineProps<Props>()

defineEmits<{
  click: []
}>()
</script>