<!-- src/components/TwoFactorStatus.vue -->
<template>
  <span
    class="px-3 py-1 rounded-full text-sm font-semibold"
    :class="enabled ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
  >
    {{ enabled ? 'Enabled' : 'Disabled' }}
  </span>
</template>

<script setup lang="ts">
defineProps<{ enabled: boolean }>()
</script>
