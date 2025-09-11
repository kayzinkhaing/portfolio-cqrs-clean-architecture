<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <StatCard
      v-for="(stat, index) in quickStats"
      :key="stat.title"
      :stat="stat"
      :animation-delay="index * 150"
    />
  </div>
</template>

<script setup lang="ts">
import { useDashboardStats } from '@/composables/useDashboardStats'
import StatCard from './StatCard.vue'

const { quickStats } = useDashboardStats()
</script>