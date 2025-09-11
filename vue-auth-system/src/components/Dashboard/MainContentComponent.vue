<template>
  <main class="flex-1 p-8 overflow-y-auto bg-gray-50 dark:bg-slate-900">
    <!-- Welcome Section (only show on dashboard home) -->
    <WelcomeSection v-if="showWelcome" />

    <!-- Quick Stats (only show on dashboard home) -->
    <QuickStatsGrid v-if="showStats" />

    <!-- Main Content Container -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
      <div class="p-6">
        <slot />
      </div>
    </div>
  </main>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'

// Components
import WelcomeSection from './WelcomeSection.vue'
import QuickStatsGrid from './QuickStatsGrid.vue'

const route = useRoute()

const showWelcome = computed(() => route.path === '/dashboard')
const showStats = computed(() => route.path === '/dashboard')
</script>

<style scoped>
/* Custom scrollbar styling */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: transparent;
}

::-webkit-scrollbar-thumb {
  background: rgba(59, 130, 246, 0.3);
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: rgba(59, 130, 246, 0.5);
}
</style>