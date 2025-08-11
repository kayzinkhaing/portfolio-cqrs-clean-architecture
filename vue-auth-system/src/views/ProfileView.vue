<template>
  <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-md shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-indigo-600">My Profile</h2>
  
    <LoadingSpinner v-if="isLoading" class="mx-auto" />
  
    <DynamicForm v-else :fields="fields" :form="profile" :errors="errors" :loading="updateLoading"
      submit-label="Update Profile" @submit="update" />
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed, watch } from 'vue'
import { getProfile, updateProfile, getTownships, getWards } from '../services/api'
import { useRouter } from 'vue-router'
import LoadingSpinner from '../components/LoadingSpinner.vue'
import DynamicForm from '@/components/DynamicForm.vue'
import { useAuthStore } from '../stores/auth'

import { profileFields } from '../config/forms/profileFields' // import new fields function

interface Township {
  id: number | string
  name: string
}
interface Ward {
  id: number | string
  township_id: number | string
  name: string
}
interface Profile {
  name: string
  email: string
  township_id: number | string | ''
  ward_id: number | string | ''
}

const router = useRouter()
const auth = useAuthStore()

const profile = ref<Profile>({
  name: '',
  email: '',
  township_id: '',
  ward_id: '',
})

const townships = ref<Township[]>([])
const wards = ref<Ward[]>([])
const errors = ref<Record<string, string>>({})

const isLoading = ref(true)
const updateLoading = ref(false)

// Filter wards by selected township
const filteredWards = computed(() => {
  if (!profile.value.township_id) return []
  return wards.value.filter(w => w.township_id === profile.value.township_id)
})

// Load wards based on selected township
const loadWards = async () => {
  if (!profile.value.township_id) {
    wards.value = []
    profile.value.ward_id = ''
    return
  }
  try {
    const res = await getWards()
    wards.value = res.data
    if (!filteredWards.value.find(w => w.id === profile.value.ward_id)) {
      profile.value.ward_id = ''
    }
  } catch (error) {
    console.error('Failed to load wards:', error)
  }
}

onMounted(async () => {
  try {
    const res = await getProfile()
    profile.value = {
      name: res.data.name || '',
      email: res.data.email || '',
      township_id: res.data.township_id || '',
      ward_id: res.data.ward_id || '',
    }

    const townshipsRes = await getTownships()
    townships.value = townshipsRes.data

    await loadWards()
  } catch (error) {
    router.push('/login')
  } finally {
    isLoading.value = false
  }
})

// Watch township change to reload wards dynamically
watch(() => profile.value.township_id, async () => {
  await loadWards()
})

// Use computed profileFields with current data & loading state
const fields = computed(() =>
  profileFields(townships.value, filteredWards.value, updateLoading.value)
)

// Submit handler
const update = async () => {
  updateLoading.value = true
  errors.value = {}

  try {
    await updateProfile(profile.value)

    auth.setUser({
      ...auth.user,
      name: profile.value.name,
      email: profile.value.email,
      township_id: profile.value.township_id,
      ward_id: profile.value.ward_id,
    })

    router.push('/')
  } catch (error: any) {
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors
    } else {
      alert('Failed to update profile.')
      console.error(error)
    }
  } finally {
    updateLoading.value = false
  }
}
</script>

