// src/composables/useLogin.ts
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useErrorStore } from '../stores/errorStore'
import { useAuthStore, type Credentials } from '../stores/auth'
import { useApiLoader } from './useApiLoader'
import { sanitizeObject } from '../utils/sanitize'
import { validateLoginForm } from '../utils/loginValidation'
import { handleApiError } from '../utils/errorHandler'
import { useSecureForm } from '../composables/useSecureForm'


interface LoginForm {
  email: string
  password: string
}
  // const { submitSecure } = useSecureForm()

export function useLogin() {
  const router = useRouter()
  const errorStore = useErrorStore()
  const auth = useAuthStore()

  const isLoading = ref(false)
  const form = ref<LoginForm>({
    email: '',
    password: '',
  })

  const { load } = useApiLoader()

  const handleLogin = async () => {
    errorStore.clearErrors()

    const validationErrors = validateLoginForm(form.value)
    if (Object.keys(validationErrors).length) {
      errorStore.setValidationErrors(validationErrors)
      return
    }

    try {
      await load(async () => {
        // Sanitize and cast input as Credentials
        const credentials = sanitizeObject(form.value) as Credentials
        // Call the auth store action that handles login API, token, user fetch
        await auth.loginUser(credentials)
        router.push('/')
      }, isLoading)
    } catch (error) {
      handleApiError(error)
    }
  }

  return {
    form,
    isLoading,
    // isSubmitting,
    errorStore,
    handleLogin,
  }
}
