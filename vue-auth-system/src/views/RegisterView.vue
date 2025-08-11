<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-center text-indigo-600 mb-4">Register</h2>
      <div v-if="errorStore.generalMessage" class="bg-red-100 text-red-700 p-2 rounded mb-3">
        {{ errorStore.generalMessage }}
      </div>
  
      <LoadingSpinner v-if="isLoading" />
  
      <DynamicForm v-else :fields="fields" :form="form" :errors="errorStore.errors" :loading="isSubmitting"
        submit-label="Register" @submit="handleRegister" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'

import { register, getTownships, getWards } from '../services/api'
import { registerFields } from '../config/forms/registerFields'
import { validateRegisterForm } from '../utils/registerValidation'
import { useApiLoader } from '../composables/useApiLoader'
import { useErrorStore } from '../stores/errorStore'
import { handleApiError } from '../utils/errorHandler'


import LoadingSpinner from '../components/LoadingSpinner.vue'
import DynamicForm from '@/components/DynamicForm.vue'

// Types
interface Township { id: number | string; name: string }
interface Ward { id: number | string; township_id: number | string; name: string }
interface RegisterForm {
  name: string
  email: string
  password: string
  password_confirmation: string
  township_id: number | string | ''
  ward_id: number | string | ''
}

const router = useRouter()
const errorStore = useErrorStore()

const isLoading = ref(true)
const isSubmitting = ref(false)

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

const fields = computed(() =>
  registerFields(townships.value, filteredWards.value)
)

watch(
  () => form.value.township_id,
  () => {
    if (!filteredWards.value.find(w => w.id === form.value.ward_id)) {
      form.value.ward_id = ''
    }
  }
)

const { load } = useApiLoader()

// Fetch townships & wards on mount
onMounted(() => {
  errorStore.clearErrors()
  load(async () => {
    const [tRes, wRes] = await Promise.all([getTownships(), getWards()])
    townships.value = tRes.data
    wards.value = wRes.data
  }, isLoading)
})

// Handle register

const handleRegister = async () => {
  errorStore.clearErrors()

  const validationErrors = validateRegisterForm(form.value)
  if (Object.keys(validationErrors).length) {
    errorStore.setValidationErrors(validationErrors)
    return
  }

  await load(async () => {
    try {
      await register(form.value)
      router.push('/login')
    } catch (error) {
      handleApiError(error)
    }
  }, isSubmitting)
}

</script>
