<template>
  <div ref="dropdownRef" class="relative">
    <!-- Trigger -->
    <button
      @click="toggleDropdown"
      class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600 font-medium focus:outline-none"
      type="button"
    >
      <span>{{ user?.name }}</span>
      <svg
        class="w-4 h-4 text-indigo-600 transition-transform duration-200"
        :class="{ 'rotate-180': showDropdown }"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
        viewBox="0 0 24 24"
        stroke-linecap="round"
        stroke-linejoin="round"
      >
        <path d="M6 9l6 6 6-6" />
      </svg>
    </button>

    <!-- Dropdown -->
    <transition
      enter-active-class="transition ease-out duration-150"
      enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition ease-in duration-100"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <div
        v-if="showDropdown"
        class="absolute right-0 mt-2 w-44 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-100"
      >
        <router-link
          to="/profile"
          class="block px-4 py-2 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition"
          @click="closeDropdown"
        >
          Profile
        </router-link>
        <button
          @click="$emit('logout')"
          class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 hover:text-red-700 transition"
        >
          Logout
        </button>
      </div>
    </transition>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount } from 'vue'

interface Props {
  user: { name: string } | null
}
defineProps<Props>()
defineEmits(['logout'])

const showDropdown = ref(false)
const dropdownRef = ref<HTMLElement | null>(null)

const toggleDropdown = () => {
  showDropdown.value = !showDropdown.value
}
const closeDropdown = () => {
  showDropdown.value = false
}

const handleClickOutside = (event: MouseEvent) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target as Node)) {
    showDropdown.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})
onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>
