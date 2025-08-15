<template>
  <div class="space-y-4">
    <button
      v-if="!enabled"
      class="w-full py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition font-semibold"
      @click="$emit('enable')"
    >
      Enable 2FA
    </button>
    <button
      v-else
      class="w-full py-2 bg-red-500 text-white rounded-lg shadow hover:bg-red-600 transition font-semibold"
      @click="$emit('disable')"
    >
      Disable 2FA
    </button>
  </div>
</template>

<script setup lang="ts">
defineProps<{ enabled: boolean }>()

defineEmits<{
  (e: 'enable'): void
  (e: 'disable'): void
}>()
</script>
