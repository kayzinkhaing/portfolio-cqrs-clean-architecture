<template>
  <button
    :disabled="loading"
    type="submit"
    class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition flex justify-center items-center disabled:opacity-50"
  >
    <span v-if="loading" class="mr-2">{{ loadingText }}</span>
    <LoadingSpinner v-if="loading" class="h-5 w-5 text-white" />
    <span v-else>
      <slot>Submit</slot>
    </span>
  </button>
</template>

<script setup lang="ts">
import LoadingSpinner from '../components/LoadingSpinner.vue'
import { PropType } from 'vue'

const props = defineProps({
  loading: {
    type: Boolean as PropType<boolean>,
    default: false,
  },
  loadingText: {
    type: String as PropType<string>,
    default: 'Loading...',
  },
})
</script>
