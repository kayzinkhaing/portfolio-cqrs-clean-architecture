<template>
  <main class="flex-1 p-8 overflow-y-auto bg-gray-50">
    <WelcomeSection v-if="showWelcome" />
    <!-- <QuickStatsGrid v-if="showStats" /> -->

    <div class="bg-white rounded-lg shadow border border-gray-200">
      <div class="p-6">
        <slot />
      </div>
    </div>
  </main>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import WelcomeSection from './WelcomeSection.vue'
// import QuickStatsGrid from './QuickStatsGrid.vue'

const route = useRoute()
const showWelcome = computed(() => route.path === '/dashboard')
const showStats = computed(() => route.path === '/dashboard')
</script>