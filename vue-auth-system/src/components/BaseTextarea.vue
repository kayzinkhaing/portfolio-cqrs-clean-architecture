<template>
  <div>
    <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1">
      {{ label }}
    </label>
    <textarea v-bind="$attrs" v-model="model" :placeholder="placeholder" :rows="rows"
      class="w-full border border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
  </div>
</template>

<script setup lang="ts">
import { computed, PropType } from 'vue'

const props = defineProps({
  modelValue: {
    type: String as PropType<string>,
    default: '',
  },
  label: {
    type: String as PropType<string>,
    default: '',
  },
  placeholder: {
    type: String as PropType<string>,
    default: '',
  },
  rows: {
    type: Number as PropType<number>,
    default: 4,
  },
})

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()

const model = computed({
  get: () => props.modelValue,
  set: (value: string) => emit('update:modelValue', value),
})
</script>
