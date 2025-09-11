<template>
  <button
    class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700 transition-all duration-300"
    @click="$emit('toggle')"
  >
    <SunIcon v-if="isDark" class="w-6 h-6 text-yellow-500" />
    <MoonIcon v-else class="w-6 h-6 text-gray-600" />
  </button>
</template>

<script setup lang="ts">
import { SunIcon, MoonIcon } from '@heroicons/vue/24/outline'

interface Props {
  isDark: boolean
}

defineProps<Props>()

defineEmits<{
  toggle: []
}>()
</script>