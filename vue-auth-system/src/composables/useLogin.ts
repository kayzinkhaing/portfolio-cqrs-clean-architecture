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

  const goToForgotPassword = () => {
    router.push('/forgot-password')
  }
  const handleLogin = async () => {
  errorStore.clearErrors()

  const validationErrors = validateLoginForm(form.value)
  if (Object.keys(validationErrors).length) {
    errorStore.setValidationErrors(validationErrors)
    return
  }

  try {
    await load(async () => {
      const credentials = sanitizeObject(form.value) as Credentials
      await auth.loginUser(credentials)

      // Check if 2FA is required
      if (auth.requires2FA) {
        router.push({ name: 'TwoFactor' }) // redirect to 2FA page
      } else {
        router.push({ name: 'Home' }) // normal home page
      }
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
    goToForgotPassword,
  }
}
