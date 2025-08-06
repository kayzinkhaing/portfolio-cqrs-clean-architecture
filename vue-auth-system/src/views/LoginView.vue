<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-center text-indigo-600 mb-4">Login</h2>
  
      <LoadingSpinner v-if="isLoading" />
  
      <form v-else @submit.prevent="handleLogin" class="space-y-4">
        <BaseInput v-model="form.email" type="email" label="Email" placeholder="Enter your email" required />
  
        <BaseInput v-model="form.password" type="password" label="Password" placeholder="Enter your password" required />
  
        <SubmitButton :loading="isLoading" label="Login" />
      </form>
  
      <p v-if="errorMessage" class="text-red-600 mt-2 text-center">{{ errorMessage }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import LoadingSpinner from '@/components/LoaderSpinner.vue'
import BaseInput from '@/components/BaseInput.vue'
import SubmitButton from '@/components/SubmitButton.vue'

const router = useRouter()
const auth = useAuthStore()

const isLoading = ref(false)
const errorMessage = ref('')

const form = ref({
  email: '',
  password: '',
})

const handleLogin = async () => {
  errorMessage.value = ''
  isLoading.value = true
  try {
    await auth.loginUser(form.value)
    router.push('/') // Redirect after login
  } catch {
    errorMessage.value = auth.error || 'Login failed. Please check your credentials.'
  } finally {
    isLoading.value = false
  }
}
</script>
