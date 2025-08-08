<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-center text-indigo-600 mb-4">Register</h2>
  
      <LoadingSpinner v-if="isLoading" />
  
      <form v-else @submit.prevent="handleRegister">
        <BaseInput v-model="form.name" placeholder="Name" :error="errors.name?.[0]" required />
        <BaseInput v-model="form.email" placeholder="Email" type="email" :error="errors.email?.[0]" required />
        <BaseInput v-model="form.password" placeholder="Password" type="password" :error="errors.password?.[0]"
          required />
        <BaseInput v-model="form.password_confirmation" placeholder="Confirm Password" type="password" required />
  
        <BaseSelect v-model="form.township_id" :options="townships" placeholder="Select Township"
          :error="errors.township_id?.[0]" required @change="onTownshipChange" />
  
        <BaseSelect v-model="form.ward_id" :options="filteredWards" placeholder="Select Ward" :error="errors.ward_id?.[0]"
          required />
  
        <SubmitButton :loading="isSubmitting">Register</SubmitButton>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { register, getTownships, getWards } from '@/services/api'
import { useRouter } from 'vue-router'
import LoadingSpinner from '@/components/LoadingSpinner.vue'
import BaseInput from '@/components/BaseInput.vue'
import BaseSelect from '@/components/BaseSelect.vue'
import SubmitButton from '@/components/SubmitButton.vue'

const router = useRouter()
const isLoading = ref(true)
const isSubmitting = ref(false)

const form = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  township_id: '',
  ward_id: '',
})

const errors = ref({})
const townships = ref([])
const wards = ref([])

const filteredWards = computed(() => {
  if (!form.value.township_id) return []
  return wards.value.filter(w => w.township_id === form.value.township_id)
})

const onTownshipChange = () => {
  if (!filteredWards.value.find(w => w.id === form.value.ward_id)) {
    form.value.ward_id = ''
  }
}

onMounted(async () => {
  try {
    const [tRes, wRes] = await Promise.all([getTownships(), getWards()])
    townships.value = tRes.data
    wards.value = wRes.data
  } catch (err) {
    alert('Failed to load data')
  } finally {
    isLoading.value = false
  }
})

const handleRegister = async () => {
  isSubmitting.value = true
  errors.value = {}

  try {
    await register(form.value)
    router.push('/login')
  } catch (err) {
    if (err.response?.status === 422) {
      errors.value = err.response.data.errors
    } else {
      alert('Registration failed! ' + (err.response?.data?.message || 'Unknown error'))
    }
  } finally {
    isSubmitting.value = false
  }
}
</script>
