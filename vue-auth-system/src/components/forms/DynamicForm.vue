<template>
  <form @submit.prevent="handleSubmit" class="space-y-6">
    <component
      v-for="field in fields"
      :key="field.model"
      :is="getComponent(field.type)"
      v-model="form[field.model]"
      v-bind="field.props"
      :label="field.label"
      :placeholder="field.placeholder"
      :type="field.type"
      :options="field.options"
      :error="errors[field.model]"
      @change="field.type === 'select' ? onSelectChange(field.model) : null"
    />

    <slot name="extra" />

    <SubmitButton :loading="loading" class="w-full">
      {{ submitLabel }}
    </SubmitButton>
  </form>
</template>

<script setup lang="ts">
import BaseInput from '@/components/forms/BaseInput.vue'
import BaseSelect from '@/components/forms/BaseSelect.vue'
import BaseTextarea from '@/components/forms/BaseTextarea.vue'
import SubmitButton from '@/components/SubmitButton.vue'

const props = defineProps({
  fields: { type: Array, required: true },
  form: { type: Object, required: true },
  errors: { type: Object, default: () => ({}) },
  loading: { type: Boolean, default: false },
  submitLabel: { type: String, default: 'Submit' }
})

const emit = defineEmits(['submit', 'update:modelValue'])

function getComponent(type: string) {
  const components = { select: BaseSelect, textarea: BaseTextarea }
  return components[type] || BaseInput
}

function onSelectChange(modelKey: string) {
  emit('update:modelValue', { ...props.form, [modelKey]: props.form[modelKey] })
}

function handleSubmit() {
  emit('submit')
}
</script>