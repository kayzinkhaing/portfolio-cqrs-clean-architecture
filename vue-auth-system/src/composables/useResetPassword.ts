import { ref } from 'vue'
import { useErrorStore } from '@/stores/errorStore'
import { resetPassword as resetPasswordApi } from '@/services/auth'
import { useAuthStore } from '@/stores/auth'

interface ResetForm {
  email: string
  token: string
  password: string
  password_confirmation: string
}

export function useResetPassword(router: any) {
  const errorStore = useErrorStore()
  const auth = useAuthStore()
  const isLoading = ref(false)
  const form = ref<ResetForm>({
    email: '',
    token: '',
    password: '',
    password_confirmation: ''
  })

  const handleResetPassword = async () => {
    errorStore.clearErrors()
    isLoading.value = true
    try {
      // 1️⃣ Call reset password API
      await resetPasswordApi(form.value)

      // 2️⃣ Automatically log in user
      await auth.loginUser({
        email: form.value.email,
        password: form.value.password
      })

      // 3️⃣ Redirect to home after login
      router.push('/')
    } catch (err: any) {
      errorStore.generalMessage = err.response?.data?.message || 'Something went wrong.'
    } finally {
      isLoading.value = false
    }
  }

  return { form, isLoading, handleResetPassword }
}
