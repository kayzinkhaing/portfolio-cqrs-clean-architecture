<template>
  <nav class="bg-white shadow-md px-6 py-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
      <!-- Logo -->
      <router-link to="/" class="text-3xl font-extrabold text-indigo-600 hover:text-indigo-800">
        MyBlog
      </router-link>
  
      <!-- Desktop Menu -->
      <div class="flex items-center space-x-6 relative">
        <template v-if="auth.initialized && auth.isAuthenticated">
          <div ref="dropdownRef" class="relative">
            <button @click="toggleDropdown"
              class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600 font-medium focus:outline-none"
              type="button">
              <span>{{ auth.user?.name }}</span>
              <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 9l6 6 6-6" />
              </svg>
            </button>
            <!-- Dropdown -->
            <div v-if="showDropdown"
              class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg py-2 z-50 border border-gray-200">
              <router-link to="/profile" class="block px-4 py-2 text-gray-700 hover:bg-indigo-100 hover:text-indigo-700"
                @click="closeDropdown">
                Profile
              </router-link>
              <button @click="handleLogout"
                class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100 hover:text-red-700">
                Logout
              </button>
            </div>
          </div>
        </template>
  
        <template v-else-if="auth.initialized">
          <router-link to="/login" class="text-gray-700 hover:text-indigo-600 font-medium transition">
            Login
          </router-link>
          <router-link to="/register" class="text-gray-700 hover:text-indigo-600 font-medium transition">
            Register
          </router-link>
        </template>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'

const auth = useAuthStore()
const router = useRouter()
const showDropdown = ref(false)
const dropdownRef = ref(null)

const handleLogout = async () => {
  await auth.logoutUser()
  router.push('/login')
  showDropdown.value = false
}

const toggleDropdown = () => {
  showDropdown.value = !showDropdown.value
}

const closeDropdown = () => {
  showDropdown.value = false
}

const handleClickOutside = (event) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    showDropdown.value = false
  }
}

onMounted(async () => {
  if (!auth.user) {
    await auth.fetchUser()
  }
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>
