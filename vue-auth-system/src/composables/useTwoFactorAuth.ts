import { ref, reactive } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { enable2FA, verify2FA, disable2FA } from '@/services/auth'

export const useTwoFactorAuth = () => {
  const auth = useAuthStore()

  const loading = ref(false)
  const message = ref('')
  const qr = ref('')
  const step = ref<'initial' | 'verify'>('initial')

  const verificationForm = reactive({ code: '' })
  const errors = reactive({ code: '' })
  const verificationFields = [
    {
      model: 'code',
      type: 'text',
      label: 'Verification Code',
      required: true,
      placeholder: 'Enter 6-digit code',
    },
  ]

  const onEnable2FA = async () => {
    loading.value = true
    message.value = ''
    try {
      const res = await enable2FA()
      qr.value = res.data.qr
      step.value = 'verify'
    } catch (err: any) {
      message.value = err.response?.data?.message || 'Failed to enable 2FA'
    } finally {
      loading.value = false
    }
  }

  const onVerify2FA = async () => {
    loading.value = true
    message.value = ''
    try {
      const res = await verify2FA(verificationForm.code)
      if (auth.user) auth.user.two_factor_enabled = true
      step.value = 'initial'
      verificationForm.code = ''
      qr.value = ''
      message.value = res.data.message || '2FA enabled successfully'
    } catch (err: any) {
      message.value = err.response?.data?.message || 'Invalid verification code'
    } finally {
      loading.value = false
    }
  }

  const onDisable2FA = async () => {
    loading.value = true
    message.value = ''
    try {
      const res = await disable2FA()
      auth.setUser(res.data.data)
      step.value = 'initial'
      message.value = res.data.message
    } catch (err: any) {
      message.value = err.response?.data?.message || 'Failed to disable 2FA'
    } finally {
      loading.value = false
    }
  }

  return {
    auth,
    loading,
    message,
    qr,
    step,
    verificationForm,
    verificationFields,
    errors,
    onEnable2FA,
    onVerify2FA,
    onDisable2FA,
  }
}
