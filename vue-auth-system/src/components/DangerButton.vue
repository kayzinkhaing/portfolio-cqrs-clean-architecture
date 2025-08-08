<template>
  <button :disabled="loading" type="button"
    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition disabled:opacity-50">
    <span v-if="loading">{{ loadingText }}</span>
    <span v-else>
      <slot>Delete</slot>
    </span>
  </button>
</template>

<script setup>
defineProps({
  loading: Boolean,
  loadingText: {
    type: String,
    default: 'Deleting...',
  },
})
</script>
