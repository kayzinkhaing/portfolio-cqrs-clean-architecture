// src/composables/useSecureForm.ts
import { ref } from 'vue'
import axiosSecure from '../services/axiosSecure'
import { sanitizeObject } from '@/utils/sanitize'
import { handleApiError } from '../utils/errorHandler'
import { useErrorStore } from '../stores/errorStore'

const COOLDOWN_MS = 3000 // 3 seconds between submissions
let lastSubmitTime = 0

export function useSecureForm() {
  const isSubmitting = ref(false)
  const errorStore = useErrorStore()

  const submitSecure = async (
    url: string,
    data: Record<string, any>,
    method: 'post' | 'put' | 'patch' = 'post'
  ) => {
    errorStore.clearErrors()

    // Step 0: Client-side throttle
    const now = Date.now()
    if (now - lastSubmitTime < COOLDOWN_MS) {
      errorStore.setGeneralError(`Please wait ${Math.ceil((COOLDOWN_MS - (now - lastSubmitTime)) / 1000)}s before submitting again.`)
      return
    }
    lastSubmitTime = now

    isSubmitting.value = true

    try {
      // Step 1: Sanitize inputs
      const cleanData = sanitizeObject(data)

      // Step 2: Get CSRF token (Laravel Sanctum)
      await axiosSecure.get('/sanctum/csrf-cookie')

      // Step 3: Send request
      const response = await axiosSecure[method](url, cleanData)

      return response.data
    } catch (error: any) {
      // Step 4: Handle server validation errors
      if (error.response?.status === 422 && error.response.data?.errors) {
        errorStore.setValidationErrors(error.response.data.errors)
      } else {
        handleApiError(error)
      }
      throw error
    } finally {
      isSubmitting.value = false
    }
  }

  return {
    isSubmitting,
    submitSecure
  }
}
