// src/composables/useRegister.ts
import { ref, computed, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'

import { registerFields } from '../config/forms/registerFields'
import { validateRegisterForm } from '../utils/registerValidation'
import { useApiLoader } from '../composables/useApiLoader'
import { useErrorStore } from '../stores/errorStore'
import { useSecureForm } from '../composables/useSecureForm'
import axiosSecure from '../services/axiosSecure'
import { handleApiError } from '../utils/errorHandler'

// Types
interface Township { id: number | string; name: string }
interface Ward { id: number | string; township_id: number | string; name: string }
export interface RegisterForm {
  name: string
  email: string
  password: string
  password_confirmation: string
  township_id: number | string | ''
  ward_id: number | string | ''
}

export function useRegister() {
  const router = useRouter()
  const errorStore = useErrorStore()

  const isLoading = ref(true)
  const form = ref<RegisterForm>({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    township_id: '',
    ward_id: '',
  })

  const townships = ref<Township[]>([])
  const wards = ref<Ward[]>([])

  const filteredWards = computed(() => {
    if (!form.value.township_id) return []
    return wards.value.filter(w => w.township_id === form.value.township_id)
  })

  const fields = computed(() => registerFields(townships.value, filteredWards.value))

  watch(() => form.value.township_id, () => {
    if (!filteredWards.value.find(w => w.id === form.value.ward_id)) {
      form.value.ward_id = ''
    }
  })

  const { load } = useApiLoader()
  const { isSubmitting, submitSecure } = useSecureForm()

  onMounted(() => {
    errorStore.clearErrors()
    load(async () => {
      const [tRes, wRes] = await Promise.all([
        axiosSecure.get('/townships'),
        axiosSecure.get('/wards')
      ])
      townships.value = tRes.data
      wards.value = wRes.data
    }, isLoading)
  })

  const handleRegister = async () => {
    errorStore.clearErrors()

    const validationErrors = validateRegisterForm(form.value)
    if (Object.keys(validationErrors).length) {
      errorStore.setValidationErrors(validationErrors)
      return
    }

    try {
      await submitSecure('/register', form.value, 'post')
      router.push('/login')
    } catch (error) {
      handleApiError(error)
    }
  }

  return {
    form,
    townships,
    wards,
    filteredWards,
    fields,
    isLoading,
    isSubmitting,
    errorStore,
    handleRegister,
  }
}
