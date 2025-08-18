<template>
  <div class="p-6">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-3xl font-bold text-indigo-600">Your Information</h1>

      <!-- Edit Profile Button -->
      <router-link
        to="/settings/profile-edit"
        class="px-4 py-2 bg-indigo-500 text-white rounded-lg shadow hover:bg-indigo-600 transition"
      >
        Edit Profile
      </router-link>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
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

// Async Heroicon
const InformationCircleIcon = defineAsyncComponent(
  () => import('@heroicons/vue/24/outline/InformationCircleIcon.js')
)

// Pinia store
const auth = useAuthStore()

// Fetch user only if not already loaded
onMounted(async () => {
  if (!auth.user) {
    try {
      await auth.fetchUser()
    } catch (error) {
      console.error('Failed to fetch profile:', error)
    }
  }
})

// Reactive info fields
const infoFields = computed(() => [
  { label: 'Name', value: auth.user?.name || '-', icon: InformationCircleIcon },
  { label: 'Email', value: auth.user?.email || '-', icon: InformationCircleIcon },
  { label: 'Township', value: auth.user?.township?.name || '-', icon: InformationCircleIcon },
  { label: 'Ward', value: auth.user?.ward?.name || '-', icon: InformationCircleIcon },
])
</script>
