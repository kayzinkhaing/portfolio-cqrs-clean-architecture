//C:\xampp\htdocs\vue-testing-project\vue-auth-system\src\components\forms\BaseSelect.vue
<template>
  <div class="mb-4">
    <label v-if="label" :for="id" class="block text-sm font-medium text-gray-700 mb-1">
      {{ label }}
    </label>
    <select :id="id" :disabled="disabled" v-model="internalValue"
      class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2"
      :class="error ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-indigo-500'">
      <option disabled value="">{{ placeholder }}</option>
      <option v-for="option in options" :key="option.id" :value="option.id">
        {{ option.name }}
      </option>
    </select>
    <p v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</p>
  </div>
</template>

<script setup lang="ts">
import { computed, PropType } from 'vue'

interface Option {
  id: string | number
  name: string
}

const props = defineProps({
  modelValue: {
    type: [String, Number] as PropType<string | number | undefined>,
    default: '',
  },
  label: String,
  id: String,
  options: {
    type: Array as PropType<Option[]>,
    required: true,
    default: () => [],
  },
  placeholder: {
    type: String,
    default: 'Select an option',
  },
  error: String,
  disabled: Boolean,
})

const emit = defineEmits<{
  (e: 'update:modelValue', value: string | number): void
}>()

const internalValue = computed({
  get: () => props.modelValue,
  set: (val: string | number) => emit('update:modelValue', val),
})
</script>
