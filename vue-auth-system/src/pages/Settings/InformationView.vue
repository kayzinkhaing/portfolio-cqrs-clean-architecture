<template>
  <div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-3xl font-bold text-indigo-600">Your Information</h1>
      <router-link
        to="/settings/profile-edit"
        class="px-4 py-2 bg-indigo-500 text-white rounded-lg shadow hover:bg-indigo-600 transition"
      >
        Edit Profile
      </router-link>
    </div>

    <!-- Loading Skeleton -->
    <div v-if="auth.profileLoading" class="grid gap-6 md:grid-cols-2">
      <div v-for="n in 4" :key="n" class="bg-gray-200 h-24 rounded-lg animate-pulse"></div>
    </div>

    <!-- Error -->
    <div v-else-if="auth.error" class="text-red-500 text-center py-6">
      {{ auth.error }}
    </div>

    <!-- Profile Info -->
    <div v-else class="grid gap-6 md:grid-cols-2">
      <div
        v-for="field in infoFields"
        :key="field.label"
        class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition duration-300"
      >
        <div class="flex items-center space-x-3">
          <component :is="field.icon" class="w-6 h-6 text-indigo-500" />
          <h3 class="text-lg font-medium text-gray-700">{{ field.label }}</h3>
        </div>
        <p class="mt-2 text-gray-600">{{ field.value }}</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, onMounted } from 'vue'
import { defineAsyncComponent } from 'vue'
import { useAuthStore } from '../../stores/auth'

// Async Heroicons
const UserIcon = defineAsyncComponent(() => import('@heroicons/vue/24/outline/UserIcon.js'))
const MailIcon = defineAsyncComponent(() => import('@heroicons/vue/24/outline/EnvelopeIcon.js'))
const MapIcon = defineAsyncComponent(() => import('@heroicons/vue/24/outline/MapIcon.js'))
const MapPinIcon = defineAsyncComponent(() => import('@heroicons/vue/24/outline/MapPinIcon.js'))

// Pinia store
const auth = useAuthStore()

// Fetch user only if not already loaded
onMounted(async () => {
  if (!auth.user) {
    try {
      await auth.fetchProfile()  // ✅ Correct function
    } catch (error) {
      console.error('Failed to fetch profile:', error)
    }
  }
})

// Reactive info fields
const infoFields = computed(() => [
  { label: 'Name', value: auth.user?.name || '-', icon: UserIcon },
  { label: 'Email', value: auth.user?.email || '-', icon: MailIcon },
  { label: 'Township', value: auth.user?.township?.name || '-', icon: MapIcon },
  { label: 'Ward', value: auth.user?.ward?.name || '-', icon: MapPinIcon },
])
</script>
