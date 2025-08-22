<!-- src/components/BaseButton.vue -->
<template>
  <button
    :type="type"
    :class="[
      'inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium rounded-lg transition duration-200',
      variantClasses,
      { 'opacity-50 cursor-not-allowed': disabled }
    ]"
    :disabled="disabled"
    @click="$emit('click')"
  >
    <!-- Icon slot -->
    <slot name="icon" />

    <!-- Button text -->
    <slot />
  </button>
</template>

<script setup lang="ts">
import { computed } from 'vue'

interface Props {
  type?: 'button' | 'submit' | 'reset'
  variant?: 'primary' | 'secondary' | 'danger'
  disabled?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  type: 'button',
  variant: 'primary',
  disabled: false
})

const variantClasses = computed(() => {
  switch (props.variant) {
    case 'primary':
      return 'bg-indigo-600 text-white hover:bg-indigo-700'
    case 'secondary':
      return 'bg-indigo-50 text-indigo-700 border border-indigo-200 hover:bg-indigo-100 hover:text-indigo-900'
    case 'danger':
      return 'bg-red-600 text-white hover:bg-red-700'
    default:
      return ''
  }
})
</script>
