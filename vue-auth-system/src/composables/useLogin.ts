import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useErrorStore } from '../stores/errorStore'
import { useAuthStore, type Credentials } from '../stores/auth'
import { useApiLoader } from './useApiLoader'
import { sanitizeObject } from '../utils/sanitize'
import { validateLoginForm } from '../utils/loginValidation'
import { handleApiError } from '../utils/errorHandler'

interface LoginForm {
  email: string
  password: string
}

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

    // Validate form
    const validationErrors = validateLoginForm(form.value)
    if (Object.keys(validationErrors).length) {
      errorStore.setValidationErrors(validationErrors)
      return
    }

    try {
      await load(async () => {
        const credentials: Credentials = sanitizeObject(form.value) as Credentials
         // LOGIN
      const loginRes = await auth.loginUser(credentials)
      // console.log('Login response:', loginRes)
      // console.log('Auth store after login:', auth)
        // LOGIN
        await auth.loginUser(credentials)

        // 2FA check
        if (auth.requires2FA) {
          router.push({ name: 'TwoFactor' })
        } else {
          router.push({ name: 'Home' })
        }
      }, isLoading)
    } catch (error: any) {
      handleApiError(error)
      // Display backend message if exists
      // if (error.response?.data?.message) {
      //   errorStore.setGeneralMessage(error.response.data.message)
      // }
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
