<template>
  <div class="space-y-2">
    <label v-if="label" class="block text-sm font-semibold text-slate-700">
      {{ label }}
    </label>
    
    <textarea 
      v-bind="$attrs" 
      v-model="model" 
      :placeholder="placeholder" 
      :rows="rows"
      :class="textareaClasses"
    />
    
    <p v-if="error" class="text-sm text-red-600">{{ error }}</p>
  </div>
</template>

<script setup lang="ts">
import { computed, PropType } from 'vue'

const props = defineProps({
  modelValue: { type: String as PropType<string>, default: '' },
  label: { type: String as PropType<string>, default: '' },
  placeholder: { type: String as PropType<string>, default: '' },
  rows: { type: Number as PropType<number>, default: 4 },
  error: String
})

const emit = defineEmits<{ (e: 'update:modelValue', value: string): void }>()

const model = computed({
  get: () => props.modelValue,
  set: (value: string) => emit('update:modelValue', value)
})

const textareaClasses = computed(() => [
  'w-full px-4 py-3 rounded-xl border transition-all duration-200',
  'focus:outline-none focus:ring-2 resize-vertical',
  props.error 
    ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' 
    : 'border-slate-300 hover:border-slate-400 focus:border-blue-500 focus:ring-blue-500/20'
])
</script>