<template>
  <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-md shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-indigo-600">My Profile</h2>
  
    <LoadingSpinner v-if="isLoading" class="mx-auto" />
  
    <form v-else @submit.prevent="update" class="space-y-4">
      <!-- Name -->
      <div>
        <label class="block text-gray-700 font-semibold mb-1" for="name">Name</label>
        <input id="name" type="text" v-model="profile.name"
          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
          required :disabled="updateLoading" />
      </div>
  
      <!-- Email -->
      <div>
        <label class="block text-gray-700 font-semibold mb-1" for="email">Email</label>
        <input id="email" type="email" v-model="profile.email"
          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
          required :disabled="updateLoading" />
      </div>
  
      <!-- Township -->
      <div>
        <label class="block text-gray-700 font-semibold mb-1" for="township">Township</label>
        <select id="township" v-model="profile.township_id" @change="loadWards"
          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
          required :disabled="updateLoading">
          <option value="" disabled>Select Township</option>
          <option v-for="township in townships" :key="township.id" :value="township.id">
            {{ township.name }}
          </option>
        </select>
      </div>
  
      <!-- Ward -->
      <div>
        <label class="block text-gray-700 font-semibold mb-1" for="ward">Ward</label>
        <select id="ward" v-model="profile.ward_id"
          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
          required :disabled="updateLoading">
          <option value="" disabled>Select Ward</option>
          <option v-for="ward in wards" :key="ward.id" :value="ward.id">
            {{ ward.name }}
          </option>
        </select>
      </div>
  
      <button type="submit"
        class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700 transition flex justify-center items-center"
        :disabled="updateLoading">
        <span v-if="updateLoading" class="mr-2">Updating...</span>
        <LoadingSpinner v-if="updateLoading" class="h-5 w-5 text-white" />
        <span v-else>Update Profile</span>
      </button>
  
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import {
  getProfile,
  updateProfile,
  logout,
  getTownships,
  getWards,
} from '@/services/api'
import { useRouter } from 'vue-router'
import LoadingSpinner from '@/components/LoaderSpinner.vue'
import { useAuthStore } from '@/stores/auth'

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

const isLoading = ref(true)       // For initial data load
const updateLoading = ref(false)  // For update button spinner

const loadWards = async () => {
  if (!profile.value.township_id) {
    wards.value = []
    profile.value.ward_id = ''
    return
  }
  try {
    const res = await getWards()
    wards.value = res.data.filter(
      (ward) => ward.township_id === profile.value.township_id
    )
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
  try {
    await updateProfile(profile.value)

    // Update Pinia auth user state
    auth.setUser({
      ...auth.user,
      name: profile.value.name,
      email: profile.value.email,
      township_id: profile.value.township_id,
      ward_id: profile.value.ward_id,
    })

    router.push('/') // Redirect to home page
  } catch (error) {
    alert('Failed to update profile.')
    console.error(error)
  } finally {
    updateLoading.value = false
  }
}

const logoutUser = async () => {
  try {
    await logout()
  } catch (error) {
    console.error(error)
  }
  router.push('/login')
}
</script>

<style scoped>
/* Optional additional styling */
</style>
