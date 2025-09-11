<template>
  <div class="space-y-2">
    <label v-if="label" :for="id" class="block text-sm font-semibold text-slate-700">
      {{ label }}
    </label>
    
    <div class="relative">
      <input
        :id="id"
        :type="type"
        :placeholder="placeholder"
        :required="required"
        :disabled="disabled"
        :autocomplete="autocomplete"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :class="inputClasses"
      />
      
      <!-- Error Icon -->
      <div v-if="error" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
        <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
    </div>
    
    <p v-if="error" class="text-sm text-red-600 flex items-center">
      {{ error }}
    </p>
  </div>
</template>

<script setup lang="ts">
import { computed, PropType } from 'vue'

const props = defineProps({
  modelValue: { type: [String, Number] as PropType<string | number | undefined>, default: '' },
  label: String,
  id: String,
  type: { type: String, default: 'text' },
  placeholder: String,
  required: Boolean,
  disabled: Boolean,
  autocomplete: String,
  error: String
})

const emit = defineEmits<{ (e: 'update:modelValue', value: string | number): void }>()

const inputClasses = computed(() => [
  'w-full px-4 py-3 rounded-xl border transition-all duration-200 focus:outline-none focus:ring-2',
  'disabled:bg-slate-50 disabled:text-slate-500 disabled:cursor-not-allowed',
  props.error 
    ? 'border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-500/20 pr-10' 
    : 'border-slate-300 bg-white hover:border-slate-400 focus:border-blue-500 focus:ring-blue-500/20'
])
</script>