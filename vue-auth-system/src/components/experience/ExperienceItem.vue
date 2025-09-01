<template>
  <div class="relative md:ml-20">
    <!-- Timeline Dot -->
    <div class="absolute left-6 w-4 h-4 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full border-4 border-gray-900 hidden md:block"></div>

    <!-- Card -->
    <div class="glass-card p-8">
      <div class="flex flex-col lg:flex-row mb-6">
  <!-- Left side -->
  <div class="lg:flex-1">
    <h3 class="text-2xl font-bold text-white">{{ experience.position }}</h3>
    <h4 class="text-xl text-indigo-400 mb-2">{{ experience.company }}</h4>
    <p class="text-white">{{ experience.location }}</p>
  </div>

  <!-- Right side -->
  <div class="mt-4 lg:mt-0 lg:flex-none text-right">
    <span v-if="!experience.end_date" class="inline-block px-4 py-2 bg-green-500/20 text-green-400 rounded-full text-sm font-semibold">
      Current Position
    </span>
    <p class="text-white mt-2">{{ formatPeriod(experience.start_date, experience.end_date) }}</p>
  </div>
</div>

      <!-- Responsibilities -->
      <div v-if="formattedResponsibilities.length" class="mb-6">
        <h5 class="text-lg font-semibold text-white mb-4">Key Responsibilities</h5>
        <ul class="list-disc ml-6 space-y-2 text-gray-300">
          <li v-for="(r, idx) in formattedResponsibilities" :key="idx">{{ r }}</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, computed } from 'vue'
import type { Experience } from '@/stores/experienceStore'

const props = defineProps<{ experience: Experience }>()

// Format period for display
const formatPeriod = (start?: string, end?: string) => {
  const s = start ? new Date(start).toLocaleDateString('en-US', { month: 'short', year: 'numeric' }) : ''
  const e = end ? new Date(end).toLocaleDateString('en-US', { month: 'short', year: 'numeric' }) : 'Present'
  return s && e ? `${s} - ${e}` : s || e || ''
}

// Convert responsibilities string into array
const formattedResponsibilities = computed(() => {
  const resp = props.experience.responsibilities
  if (!resp) return []
  if (Array.isArray(resp)) return resp
  return (resp as string).split(',').map(r => r.trim())
})

</script>
