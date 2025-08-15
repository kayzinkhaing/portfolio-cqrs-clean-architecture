import { ref } from 'vue'
import { useErrorStore } from '@/stores/errorStore'
import { forgotPassword as forgotPasswordApi } from '@/services/auth'

interface ForgotPasswordForm {
  email: string
}

export function useForgotPassword() {
  const form = ref<ForgotPasswordForm>({ email: '' })
  const isLoading = ref(false)
  const successMessage = ref('')
  const errorStore = useErrorStore()

  const handleForgotPassword = async () => {
    errorStore.clearErrors()
    successMessage.value = ''

    try {
      isLoading.value = true
      const response = await forgotPasswordApi(form.value.email)
      successMessage.value = response.data.message
    } catch (err: any) {
      errorStore.generalMessage = err.response?.data?.message || 'Something went wrong.'
    } finally {
      isLoading.value = false
    }
  }

  return { form, isLoading, errorStore, successMessage, handleForgotPassword }
}
