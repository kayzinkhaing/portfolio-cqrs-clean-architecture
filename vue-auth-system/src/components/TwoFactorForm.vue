<template>
  <DynamicForm
    :fields="fields"
    :form="form"
    :errors="errors"
    :loading="loading"
    submit-label="Verify & Enable 2FA"
    @submit="$emit('submit')"
  />
</template>

<script setup lang="ts">
import DynamicForm from './DynamicForm.vue'

defineProps<{
  form: any
  fields: any[]
  errors: any
  loading: boolean
}>()

defineEmits<{
  (e: 'submit'): void
}>()
</script>
