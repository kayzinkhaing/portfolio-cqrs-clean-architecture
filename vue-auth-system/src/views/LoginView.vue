<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-center text-indigo-600 mb-4">Login</h2>
  
      <LoadingSpinner v-if="isLoading" />
  
      <form v-else @submit.prevent="handleLogin">
        <input v-model="form.email" type="email" placeholder="Email" required class="input" />
        <input v-model="form.password" type="password" placeholder="Password" required class="input" />
  
        <button type="submit" class="btn">Login</button>
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
    router.push('/')  // redirect after login
  } catch {
    errorMessage.value = auth.error || 'Login failed. Please check your credentials.'
  } finally {
    isLoading.value = false
  }
}
</script>
