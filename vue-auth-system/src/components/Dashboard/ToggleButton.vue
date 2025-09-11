<template>
  <button
    class="p-2 rounded-xl hover:bg-slate-700 transition-all duration-300 group"
    @click="$emit('click')"
  >
    <Bars3Icon class="w-6 h-6 text-slate-300 group-hover:text-white transition-colors" />
  </button>
</template>

<script setup lang="ts">
import { Bars3Icon } from '@heroicons/vue/24/outline'

defineEmits<{
  click: []
}>()
</script>