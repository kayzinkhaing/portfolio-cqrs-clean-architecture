// src/composables/useRegister.ts
import { ref, computed, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import { getTownships, getWards } from '../api/queries/locationQuery'
import { useErrorStore } from '../stores/errorStore'
import { registerUser } from '../api/commands/authCommand'
import { registerFields } from '../config/forms/registerFields'
import { validateRegisterForm } from '../utils/registerValidation'
import { useApiLoader } from '../composables/useApiLoader'
import { useSecureForm } from '../composables/useSecureForm'
import { handleApiError } from '../utils/errorHandler'

// ------------------------
// Types
// ------------------------
interface Township { id: number; name: string }
interface Ward { id: string; name: string; township_id: number; township?: { id: number; name: string } }

export interface RegisterForm {
  name: string
  email: string
  password: string
  password_confirmation: string
  township_id: number | null
  ward_id: string | null
}

// ------------------------
// Composable
// ------------------------
export function useRegister() {
  const router = useRouter()
  const errorStore = useErrorStore()

  const form = ref<RegisterForm>({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    township_id: null,
    ward_id: null,
  })

  const townships = ref<Township[]>([])
  const wards = ref<Ward[]>([])

  const { load } = useApiLoader()
  const { isSubmitting } = useSecureForm()

  // Filter wards by selected township
  const filteredWards = computed(() => {
    const selectedId = form.value.township_id
    if (selectedId === null) return []
    return wards.value.filter(w => w.township_id === selectedId)
  })

  // ------------------------
  // Load townships on mount
  // ------------------------
  onMounted(() => {
    errorStore.clearErrors()
    load(async () => {
      try {
        const tRes = await getTownships()
        townships.value = Array.isArray(tRes) ? tRes : []

        // If a township is preselected, load its wards
        if (form.value.township_id !== null) {
          const wRes = await getWards(form.value.township_id)
          wards.value = Array.isArray(wRes) ? wRes : []
        }
      } catch (err) {
        console.error('GraphQL load error:', err)
      }
    })
  })

  // ------------------------
  // Watch township change
  // ------------------------
  watch(() => form.value.township_id, async (newId) => {
    form.value.ward_id = null
    if (newId === null) {
      wards.value = []
      return
    }
    try {
      const wRes = await getWards(newId)
      wards.value = Array.isArray(wRes) ? wRes : []
    } catch (err) {
      console.error('Failed to fetch wards:', err)
    }
  })

  // ------------------------
  // Handle registration
  // ------------------------
  const handleRegister = async () => {
  errorStore.clearErrors()

  const validationErrors = validateRegisterForm(form.value)
  if (Object.keys(validationErrors).length) {
    errorStore.setValidationErrors(validationErrors)
    return
  }

  try {
    // Prepare payload for backend
    const payload = {
      ...form.value,
      township_id: Number(form.value.township_id), // convert township_id to number
      ward_id: Number(form.value.ward_id),         // convert ward_id to number if backend expects integer
    }

    console.log("Payload for backend:", payload)

    const res = await registerUser(payload)
    if (res?.data) router.push('/login')
    else errorStore.setGeneralError(res?.message || 'Registration failed')
  } catch (err) {
    handleApiError(err)
  }
}


  return {
    form,
    townships,
    wards,
    filteredWards,
    fields: computed(() => registerFields(townships.value, filteredWards.value)),
    errorStore,
    isSubmitting,
    handleRegister,
  }
}
