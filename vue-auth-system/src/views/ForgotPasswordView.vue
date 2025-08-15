<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-center text-indigo-600 mb-4">
        Forgot Password
      </h2>

      <div v-if="successMessage" class="bg-green-100 text-green-700 p-2 rounded mb-3">
        {{ successMessage }}
      </div>

      <div v-if="errorStore.generalMessage" class="bg-red-100 text-red-700 p-2 rounded mb-3">
        {{ errorStore.generalMessage }}
      </div>

      <LoadingSpinner v-if="isLoading" />

      <DynamicForm
        v-else
        :fields="fields"
        :form="form"
        :errors="errorStore.errors"
        :loading="isLoading"
        submit-label="Send Reset Link"
        @submit="handleForgotPassword"
      />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import LoadingSpinner from '@/components/LoadingSpinner.vue'
import DynamicForm from '@/components/DynamicForm.vue'
import { useForgotPassword } from '@/composables/useForgotPassword'
import { forgotPasswordFields } from '@/config/forms/forgotPasswordFields'

export default defineComponent({
  components: {
    LoadingSpinner,
    DynamicForm,
  },
  setup() {
    const { form, isLoading, errorStore, successMessage, handleForgotPassword } = useForgotPassword()

    return {
      form,
      fields: forgotPasswordFields,
      isLoading,
      errorStore,
      successMessage,
      handleForgotPassword,
    }
  },
})
</script>
