<template>
  <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-md shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-indigo-600">My Profile</h2>
  
    <LoadingSpinner v-if="isLoading" class="mx-auto" />
  
    <form v-else @submit.prevent="update" class="space-y-4">
      <BaseInput v-model="profile.name" label="Name" id="name" required :disabled="updateLoading" :error="errors.name" />
  
      <BaseInput v-model="profile.email" label="Email" id="email" type="email" required :disabled="updateLoading"
        :error="errors.email" />
  
      <BaseSelect v-model="profile.township_id" label="Township" id="township" :options="townships"
        placeholder="Select Township" required :disabled="updateLoading" :error="errors.township_id"
        @update:modelValue="loadWards" />
  
      <BaseSelect v-model="profile.ward_id" label="Ward" id="ward" :options="wards" placeholder="Select Ward" required
        :disabled="updateLoading" :error="errors.ward_id" />
  
      <SubmitButton :loading="updateLoading" loadingText="Updating...">
        Update Profile
      </SubmitButton>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { getProfile, updateProfile, getTownships, getWards } from '@/services/api'
import { useRouter } from 'vue-router'
import LoadingSpinner from '@/components/LoadingSpinner.vue'
import { useAuthStore } from '@/stores/auth'

import BaseInput from '@/components/BaseInput.vue'
import BaseSelect from '@/components/BaseSelect.vue'
import SubmitButton from '@/components/SubmitButton.vue'

const router = useRouter()
const auth = useAuthStore()

const profile = ref({
  name: '',
  email: '',
  township_id: '',
  ward_id: '',
})

const townships = ref([])
const wards = ref([])
const errors = ref({})

const isLoading = ref(true)
const updateLoading = ref(false)

const loadWards = async () => {
  if (!profile.value.township_id) {
    wards.value = []
    profile.value.ward_id = ''
    return
  }
  try {
    const res = await getWards()
    wards.value = res.data.filter((ward) => ward.township_id === profile.value.township_id)
    if (!wards.value.find((w) => w.id === profile.value.ward_id)) {
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

const update = async () => {
  updateLoading.value = true
  errors.value = {}
  try {
    await updateProfile(profile.value)

    // Optionally update auth user info in store
    auth.setUser({
      ...auth.user,
      name: profile.value.name,
      email: profile.value.email,
      township_id: profile.value.township_id,
      ward_id: profile.value.ward_id,
    })

    router.push('/')
  } catch (error) {
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
