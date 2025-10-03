<template>
  <button
    :class="[
      'group w-full flex items-center gap-3 rounded-xl transition-all duration-300',
      'hover:scale-[1.02] active:scale-[0.98]',
      isCollapsed ? 'justify-center px-3 py-4' : 'justify-start px-4 py-3'
    ]"
    :style="{ animationDelay: `${animationDelay}ms` }"
    @click="$emit('click')"
  >
    <component 
      :is="item.icon" 
      :class="[
        'transition-all duration-300',
        isCollapsed ? 'w-7 h-7' : 'w-5 h-5',
        isActive ? 'text-white' : 'text-slate-400 group-hover:text-blue-400'
      ]"
    />
    <span 
      v-if="!isCollapsed"
      class="font-medium text-sm"
    >
      {{ item.name }}
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