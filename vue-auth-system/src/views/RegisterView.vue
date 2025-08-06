<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-center text-indigo-600 mb-4">Register</h2>

      <LoadingSpinner v-if="isLoading" />

      <form v-else @submit.prevent="handleRegister">
        <div class="mb-4">
          <input v-model="form.name" placeholder="Name" required class="w-full p-2 border border-gray-300 rounded" />
          <p v-if="errors.name" class="text-red-600 text-sm mt-1">{{ errors.name[0] }}</p>
        </div>

        <div class="mb-4">
          <input v-model="form.email" type="email" placeholder="Email" required
            class="w-full p-2 border border-gray-300 rounded" />
          <p v-if="errors.email" class="text-red-600 text-sm mt-1">{{ errors.email[0] }}</p>
        </div>

        <div class="mb-4">
          <input v-model="form.password" type="password" placeholder="Password" required
            class="w-full p-2 border border-gray-300 rounded" />
          <p v-if="errors.password" class="text-red-600 text-sm mt-1">{{ errors.password[0] }}</p>
        </div>

        <div class="mb-4">
          <input v-model="form.password_confirmation" type="password" placeholder="Confirm Password" required
            class="w-full p-2 border border-gray-300 rounded" />
        </div>

        <div class="mb-4">
          <select
            v-model="form.township_id"
            required
            class="w-full p-2 border border-gray-300 rounded bg-white"
            @change="onTownshipChange"
          >
            <option disabled value="">Select Township</option>
            <option v-for="t in townships" :key="t.id" :value="t.id">{{ t.name }}</option>
          </select>
          <p v-if="errors.township_id" class="text-red-600 text-sm mt-1">{{ errors.township_id[0] }}</p>
        </div>

        <div class="mb-4">
          <select v-model="form.ward_id" required class="w-full p-2 border border-gray-300 rounded bg-white">
            <option disabled value="">Select Ward</option>
            <option v-for="w in filteredWards" :key="w.id" :value="w.id">{{ w.name }}</option>
          </select>
          <p v-if="errors.ward_id" class="text-red-600 text-sm mt-1">{{ errors.ward_id[0] }}</p>
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white p-2 rounded hover:bg-indigo-700">
          Register
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { register, getTownships, getWards } from '@/services/api'
import { useRouter } from 'vue-router'
import LoadingSpinner from '@/components/LoaderSpinner.vue'

const router = useRouter()
const isLoading = ref(true)

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

// Compute wards filtered by selected township
const filteredWards = computed(() => {
  if (!form.value.township_id) return []
  return wards.value.filter(w => w.township_id === form.value.township_id)
})

const onTownshipChange = () => {
  // Reset ward selection if it doesn't belong to new township
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
  }
}
</script>
