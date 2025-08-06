<template>
  <div class="mb-4">
    <label v-if="label" :for="id" class="block text-sm font-medium text-gray-700 mb-1">
      {{ label }}
    </label>
    <input
      :id="id"
      :type="type"
      :placeholder="placeholder"
      :required="required"
      :disabled="disabled"
      :autocomplete="autocomplete"
      :class="[
        'w-full border rounded-md px-3 py-2 focus:outline-none',
        error ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-indigo-500'
      ]"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
    />
    <p v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</p>
  </div>
</template>

<script setup>
defineProps({
  modelValue: [String, Number],
  label: String,
  id: String,
  type: { type: String, default: 'text' },
  placeholder: String,
  required: Boolean,
  disabled: Boolean,
  autocomplete: String,
  error: String,
})
defineEmits(['update:modelValue'])
</script>
