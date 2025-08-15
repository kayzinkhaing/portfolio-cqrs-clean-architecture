<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-center text-indigo-600 mb-4">
        Reset Password
      </h2>

      <DynamicForm
        :fields="fields"
        :form="form"
        :errors="errorStore.errors"
        :loading="isLoading"
        submit-label="Reset Password"
        @submit="handleResetPassword"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import DynamicForm from '@/components/DynamicForm.vue'
import { useErrorStore } from '../stores/errorStore'
import { useResetPassword } from '../composables/useResetPassword'
import { resetPasswordFields } from '../config/forms/resetPasswordFields'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const errorStore = useErrorStore()

// composable handles reset + login + redirect
const { form, isLoading, handleResetPassword } = useResetPassword(router)

const fields = resetPasswordFields

// prefill token and email from query params
onMounted(() => {
  const token = route.query.token as string || ''
  const email = route.query.email as string || ''
  form.value.email = email
  form.value.token = token
})
</script>
