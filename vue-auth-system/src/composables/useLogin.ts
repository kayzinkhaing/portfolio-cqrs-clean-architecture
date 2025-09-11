// src/composables/useLogin.ts
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useErrorStore } from '../stores/errorStore.js'
import { useAuthStore } from '../stores/auth'
import { useApiLoader } from './useApiLoader'
import { sanitizeObject } from '../utils/sanitize'
import { validateLoginForm } from '../utils/loginValidation'
import { handleApiError } from '../utils/errorHandler'
import type { LoginData } from '../api/types' // ✅ use LoginData from types.ts

export function useLogin() {
  const router = useRouter()
  const errorStore = useErrorStore()
  const auth = useAuthStore()

  const isLoading = ref(false)
  const form = ref<LoginData>({
    email: '',
    password: '',
  })

  const { load } = useApiLoader()

  const goToForgotPassword = () => {
    router.push('/forgot-password')
  }

  const handleLogin = async () => {
    // Clear previous errors
    errorStore.clearErrors()

    // Validate form
    const validationErrors = validateLoginForm(form.value)
    if (Object.keys(validationErrors).length) {
      errorStore.setValidationErrors(validationErrors)
      return
    }

    try {
      await load(async () => {
        const credentials: LoginData = sanitizeObject(form.value) as LoginData

        // Call Pinia auth store login action
        await auth.login(credentials)

        // Check if there was an error from the store
        if (auth.error) {
          errorStore.setGeneralError(auth.error)
          return
        }

        // 2FA check
        if (auth.requires2FA) {
          router.push({ name: 'TwoFactor' })
        } else {
          router.push({ name: 'DashboardHome' })
        }
      }, isLoading)
    } catch (error: any) {
      handleApiError(error)
      if (error.response?.data?.message) {
        errorStore.setGeneralError(error.response.data.message)
      }
    }
  }

  return {
    form,
    isLoading,
    errorStore,
    handleLogin,
    goToForgotPassword,
  }
}
