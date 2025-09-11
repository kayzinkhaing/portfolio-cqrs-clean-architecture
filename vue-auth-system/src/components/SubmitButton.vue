<template>
  <button
    :disabled="loading"
    type="submit"
    :class="buttonClasses"
  >
    <!-- Loading State -->
    <template v-if="loading">
      <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
      </svg>
      {{ loadingText }}
    </template>
    
    <!-- Default State -->
    <template v-else>
      <slot>Submit</slot>
    </template>
  </button>
</template>

<script setup lang="ts">
import { computed, PropType } from 'vue'

const props = defineProps({
  loading: { type: Boolean as PropType<boolean>, default: false },
  loadingText: { type: String as PropType<string>, default: 'Processing...' },
  variant: { type: String as PropType<'primary' | 'secondary'>, default: 'primary' }
})

const buttonClasses = computed(() => [
  'w-full flex items-center justify-center px-6 py-3 rounded-xl font-semibold',
  'transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2',
  'disabled:cursor-not-allowed transform active:scale-[0.98]',
  props.variant === 'primary' 
    ? 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500 disabled:bg-blue-400'
    : 'bg-slate-100 hover:bg-slate-200 text-slate-900 focus:ring-slate-500 disabled:bg-slate-50'
])
</script>