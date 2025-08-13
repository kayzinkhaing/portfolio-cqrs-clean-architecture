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
        @submit="handleLogin" />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import LoadingSpinner from '../components/LoadingSpinner.vue'
import DynamicForm from '@/components/DynamicForm.vue'
import { useLogin } from '../composables/useLogin'
import { loginFields } from '../config/forms/loginFields'

export default defineComponent({
  components: {
    LoadingSpinner,
    DynamicForm,
  },
  setup() {
    const login = useLogin()

    return {
      ...login,
      fields: loginFields,
    }
  }
})
</script>
