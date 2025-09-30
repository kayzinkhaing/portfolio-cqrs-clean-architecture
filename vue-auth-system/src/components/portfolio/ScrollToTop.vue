<template>
  <transition
    enter-active-class="transition-opacity duration-300 ease-out"
    leave-active-class="transition-opacity duration-200 ease-in"
  >
    <button
      v-if="isVisible"
      @click="scrollToTop"
      class="fixed bottom-8 right-8 z-40 w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-full shadow-lg transform hover:scale-110 transition-transform duration-300"
      title="Back to Top"
    >
      <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
      </svg>
    </button>
  </transition>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'

const isVisible = ref(false)

// Throttle function to reduce scroll checks
const throttle = (fn: Function, limit = 100) => {
  let waiting = false
  return (...args: any[]) => {
    if (!waiting) {
      fn(...args)
      waiting = true
      setTimeout(() => (waiting = false), limit)
    }
  }
}

// Scroll check, only updates reactive value if changed
const checkScroll = () => {
  const visible = window.scrollY > 300
  if (visible !== isVisible.value) isVisible.value = visible
}

const checkScrollThrottled = throttle(checkScroll, 100)

const scrollToTop = () => {
  window.scrollTo({ top: 0, behavior: 'smooth' })
}

onMounted(() => {
  window.addEventListener('scroll', checkScrollThrottled)
  checkScrollThrottled()
})

onUnmounted(() => {
  window.removeEventListener('scroll', checkScrollThrottled)
})
</script>

<style scoped>
button {
  will-change: transform, opacity;
}
</style>
