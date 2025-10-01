<template>
  <div class="min-h-screen bg-gray-900 relative">

    <!-- Static Gradient Background -->
    <div class="fixed inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 z-0"></div>

    <!-- Subtle Animated Overlays -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 rounded-full blur-3xl animate-pulse-slow"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-pink-500/10 to-indigo-500/10 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: -2s;"></div>

    <!-- Navigation (Lazy Loaded) -->
    <component :is="PortfolioNav" />

    <!-- Main Content -->
    <main class="relative z-10">
      <router-view v-slot="{ Component, route }">
        <transition
          name="fade"
          mode="out-in"
          enter-active-class="transition-opacity duration-300"
          leave-active-class="transition-opacity duration-200"
          enter-from-class="opacity-0"
          enter-to-class="opacity-100"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <component :is="Component" :key="route.path" />
        </transition>
      </router-view>
    </main>

    <!-- Footer (Lazy Loaded) -->
    <component :is="PortfolioFooter" />

    <!-- Scroll to Top (Lazy Loaded) -->
    <component :is="ScrollToTop" />
  </div>
</template>

<script setup lang="ts">
import { defineAsyncComponent } from 'vue'

// Lazy-loaded components
const PortfolioNav = defineAsyncComponent(() => import('@/components/portfolio/PortfolioNav.vue'))
const PortfolioFooter = defineAsyncComponent(() => import('@/components/portfolio/PortfolioFooter.vue'))
const ScrollToTop = defineAsyncComponent(() => import('@/components/portfolio/ScrollToTop.vue'))
</script>

<style scoped>
/* Fade transition for pages */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

/* Slow pulse animation for gradient overlays */
@keyframes pulse-slow {
  0%, 100% { opacity: 0.15; transform: scale(1); }
  50% { opacity: 0.25; transform: scale(1.05); }
}
.animate-pulse-slow {
  animation: pulse-slow 10s ease-in-out infinite;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .absolute.w-96.h-96 { display: none; }
}
</style>
