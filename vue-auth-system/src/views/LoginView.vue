<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-center text-indigo-600 mb-4">Login</h2>
      
      <div v-if="errorStore.generalMessage" class="bg-red-100 text-red-700 p-2 rounded mb-3">
        {{ errorStore.generalMessage }}
      </div>
      
      <LoadingSpinner v-if="isLoading" />
  
      <DynamicForm 
        v-else 
        :fields="fields" 
        :form="form" 
        :errors="errorStore.errors" 
        :loading="isSubmitting"
        submit-label="Login" 
        @submit="handleLogin" 
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'

import { loginFields } from '../config/forms/loginFields'
import { validateLoginForm } from '../utils/loginValidation'
import { useApiLoader } from '../composables/useApiLoader'
import { useErrorStore } from '../stores/errorStore'
import { handleApiError } from '../utils/errorHandler'
import { useAuthStore } from '../stores/auth'

import LoadingSpinner from '../components/LoadingSpinner.vue'
import DynamicForm from '@/components/DynamicForm.vue'

// Define LoginForm type
interface LoginForm {
  email: string
  password: string
}

const router = useRouter()
const errorStore = useErrorStore()
const auth = useAuthStore()  // Import auth store

const isLoading = ref(false)
const isSubmitting = ref(false)

const form = ref<LoginForm>({
  email: '',
  password: '',
})

// Form fields definition (kept simple and reusable)
const fields = loginFields

const { load } = useApiLoader()

const handleLogin = async () => {
  errorStore.clearErrors()

  const validationErrors = validateLoginForm(form.value)
  if (Object.keys(validationErrors).length) {
    errorStore.setValidationErrors(validationErrors)
    return
  }

  await load(async () => {
    try {
      // Use the auth store action to login and update global state
      await auth.loginUser(form.value)
      router.push('/')
    } catch (error) {
      handleApiError(error)  
    }
  }, isSubmitting)
}
</script>
