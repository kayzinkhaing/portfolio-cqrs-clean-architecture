<template>
  <button :disabled="loading" type="submit"
    class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition flex justify-center items-center disabled:opacity-50">
    <span v-if="loading" class="mr-2">{{ loadingText }}</span>
    <LoadingSpinner v-if="loading" class="h-5 w-5 text-white" />
    <span v-else>
      <slot>Submit</slot>
    </span>
  </button>
</template>

<script setup>
import LoadingSpinner from '@/components/LoadingSpinner.vue'

defineProps({
  loading: Boolean,
  loadingText: { type: String, default: 'Loading...' },
})
</script>
