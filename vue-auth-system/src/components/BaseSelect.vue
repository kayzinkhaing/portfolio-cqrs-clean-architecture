<template>
  <div class="mb-4">
    <label :for="id" class="block text-sm font-medium text-gray-700 mb-1">
      {{ label }}
    </label>
    <select
      :id="id"
      :disabled="disabled"
      v-model="internalValue"
      class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2"
      :class="error ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-indigo-500'"
    >
      <option disabled value="">{{ placeholder }}</option>
      <option v-for="option in options" :key="option.id" :value="option.id">
        {{ option.name }}
      </option>
    </select>
    <p v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</p>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: [String, Number],
  label: String,
  id: String,
  options: Array,
  placeholder: String,
  error: String,
  disabled: Boolean,
})

const emit = defineEmits(['update:modelValue'])

const internalValue = computed({
  get: () => props.modelValue,
  set: (val) => emit('update:modelValue', val),
})
</script>
