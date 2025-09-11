<template>
  <div class="space-y-2">
    <label v-if="label" :for="id" class="block text-sm font-semibold text-slate-700">
      {{ label }}
    </label>
    
    <div class="relative">
      <select 
        :id="id" 
        :disabled="disabled" 
        v-model="internalValue"
        :class="selectClasses"
      >
        <option disabled value="">{{ placeholder }}</option>
        <option v-for="option in options" :key="option.id" :value="option.id">
          {{ option.name }}
        </option>
      </select>
      
      <!-- Custom Arrow -->
      <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </div>
    </div>
    
    <p v-if="error" class="text-sm text-red-600">{{ error }}</p>
  </div>
</template>

<script setup lang="ts">
import { computed, PropType } from 'vue'

interface Option {
  id: string | number
  name: string
}

const props = defineProps({
  modelValue: { type: [String, Number] as PropType<string | number | undefined>, default: '' },
  label: String,
  id: String,
  options: { type: Array as PropType<Option[]>, required: true, default: () => [] },
  placeholder: { type: String, default: 'Select an option' },
  error: String,
  disabled: Boolean
})

const emit = defineEmits<{ (e: 'update:modelValue', value: string | number): void }>()

const internalValue = computed({
  get: () => props.modelValue,
  set: (val: string | number) => emit('update:modelValue', val)
})

const selectClasses = computed(() => [
  'w-full px-4 py-3 rounded-xl border transition-all duration-200 focus:outline-none focus:ring-2',
  'appearance-none bg-white cursor-pointer',
  'disabled:bg-slate-50 disabled:text-slate-500 disabled:cursor-not-allowed',
  props.error 
    ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' 
    : 'border-slate-300 hover:border-slate-400 focus:border-blue-500 focus:ring-blue-500/20'
])
</script>