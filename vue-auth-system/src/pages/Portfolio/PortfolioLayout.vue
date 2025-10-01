<template>
  <div class="min-h-screen bg-gray-900 relative">

    <!-- Animated Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
      <!-- Gradient Background -->
      <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
      
      <!-- Particles -->
      <div class="particles-bg">
        <div
          v-for="i in 50"
          :key="i"
          class="particle"
          :style="getParticleStyle(i)"
        ></div>
      </div>

      <!-- Gradient Overlays -->
      <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 rounded-full blur-3xl animate-pulse"></div>
      <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-pink-500/10 to-indigo-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: -2s;"></div>
    </div>

    <!-- Navigation -->
    <PortfolioNav />

    <!-- Main Content -->
    <main class="relative z-10">
      <router-view v-slot="{ Component, route }">
        <transition
          name="page"
          mode="out-in"
          enter-active-class="transition-all duration-500 ease-out"
          leave-active-class="transition-all duration-300 ease-in"
          enter-from-class="opacity-0 translate-y-8 scale-95"
          enter-to-class="opacity-100 translate-y-0 scale-100"
          leave-from-class="opacity-100 translate-y-0 scale-100"
          leave-to-class="opacity-0 -translate-y-8 scale-105"
        >
          <component :is="Component" :key="route.path" />
        </transition>
      </router-view>
    </main>

    <!-- Footer -->
    <PortfolioFooter />

    <!-- Scroll to Top -->
    <ScrollToTop />

    <!-- Loading Overlay -->
    <div
      v-if="isLoading"
      class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm"
    >
      <div class="text-center">
        <div class="w-16 h-16 border-4 border-indigo-500/30 border-t-indigo-500 rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-slate-300">Loading...</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import PortfolioNav from '@/components/portfolio/PortfolioNav.vue'
import PortfolioFooter from '@/components/portfolio/PortfolioFooter.vue'
import ScrollToTop from '@/components/portfolio/ScrollToTop.vue'

const router = useRouter()
const isLoading = ref(false)

// Particle animation
const getParticleStyle = (index: number) => {
  const size = Math.random() * 3 + 1
  const left = Math.random() * 100
  const animationDuration = Math.random() * 10 + 10
  const animationDelay = Math.random() * 10

  return {
    width: `${size}px`,
    height: `${size}px`,
    left: `${left}%`,
    top: `${Math.random() * 100}%`,
    animationDuration: `${animationDuration}s`,
    animationDelay: `${animationDelay}s`,
    opacity: Math.random() * 0.5 + 0.2,
  }
}

// Loading state
const handleRouteChange = () => {
  isLoading.value = true
  setTimeout(() => (isLoading.value = false), 500)
}

// Page title
const updatePageTitle = (to: any) => {
  const baseTitle = 'Kay Zin Khaing - Full Stack Developer'
  document.title = to.meta?.title || baseTitle
}

onMounted(() => {
  router.beforeEach((to) => {
    updatePageTitle(to)
    handleRouteChange()
  })
  updatePageTitle(router.currentRoute.value)
})
</script>

<style scoped>
/* Page transitions */
.page-enter-active,
.page-leave-active {
  transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.page-enter-from { opacity: 0; transform: translateY(30px) scale(0.95); }
.page-leave-to { opacity: 0; transform: translateY(-30px) scale(1.05); }

/* Particle styles */
.particle {
  position: absolute;
  background: rgba(99, 102, 241, 0.3);
  border-radius: 50%;
  animation: float 20s linear infinite;
}

@keyframes float {
  0% { transform: translateY(100vh) rotate(0deg); }
  100% { transform: translateY(-100px) rotate(360deg); }
}

/* Hide particles on mobile */
@media (max-width: 768px) {
  .particles-bg { display: none; }
}
</style>
