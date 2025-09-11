<template>
  <div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-200 to-purple-200">
    <div class="w-full max-w-md">
      <!-- Header -->
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-black">Welcome back</h1>
        <p class="text-gray mt-2">Sign in to your account</p>
      </div>

      <!-- Form Card -->
      <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">
        <!-- Error Message -->
        <div v-if="errorStore.generalMessage" class="mb-6">
          <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            {{ errorStore.generalMessage }}
          </div>
        </div>

        <!-- Loading State -->
        <LoadingSpinner v-if="isLoading" />

        <!-- Dynamic Form -->
        <DynamicForm 
          v-else 
          :fields="fields" 
          :form="form" 
          :errors="errorStore.errors" 
          :loading="isLoading"
          submit-label="Sign In" 
          @submit="handleLogin"
        >
          <template #extra>
            <div class="flex items-center justify-between text-sm">
              <label class="flex items-center">
                <input type="checkbox" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-slate-600">Remember me</span>
              </label>
              <button 
                type="button" 
                @click="goToForgotPassword"
                class="text-blue-600 hover:text-blue-800 font-medium transition-colors"
              >
                Forgot password?
              </button>
            </div>
          </template>
        </DynamicForm>

        <!-- Sign Up Link -->
        <div class="mt-6 text-center">
          <p class="text-slate-600 text-sm">
            Don't have an account? 
            <button class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
              Sign up
            </button>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import LoadingSpinner from '../components/LoadingSpinner.vue'
import DynamicForm from '@/components/forms/DynamicForm.vue'
import { useLogin } from '../composables/useLogin'
import { loginFields } from '../config/forms/loginFields'

export default defineComponent({
  components: { LoadingSpinner, DynamicForm },
  setup() {
    const login = useLogin()
    return { ...login, fields: loginFields }
  }
})
</script>