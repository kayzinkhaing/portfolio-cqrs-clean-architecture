<template>
  <article class="bg-gray-800 rounded-xl border border-gray-700 hover:border-purple-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-purple-500/10 overflow-hidden">
    <div class="p-8">
      <!-- Top Section: Title & Date -->
      <div class="mb-6">
        <div class="flex items-center gap-3 mb-3">
          <h3 class="text-2xl font-bold text-white">{{ experience.position }}</h3>
          <span v-if="!experience.end_date" class="flex items-center gap-1.5 px-3 py-1 bg-green-500/20 border border-green-500/30 text-green-400 text-xs font-semibold rounded-full">
            <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
            Current
          </span>
        </div>
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4 text-gray-400">
            <div class="flex items-center gap-2">
              <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
              <span class="text-white font-semibold">{{ experience.company }}</span>
            </div>
            <span class="text-gray-600">|</span>
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span>{{ experience.location }}</span>
            </div>
          </div>
          <div class="text-right flex-shrink-0">
            <div class="flex items-center justify-end gap-2 text-gray-300">
              <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <span class="font-medium">{{ formatPeriod(experience.start_date, experience.end_date) }}</span>
              <span class="text-gray-600">•</span>
              <span class="text-sm text-gray-500">{{ calculateDuration(experience.start_date, experience.end_date) }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Divider -->
      <div class="h-px bg-gradient-to-r from-transparent via-gray-700 to-transparent mb-6"></div>

      <!-- Responsibilities -->
      <div v-if="formattedResponsibilities.length">
        <h4 class="text-purple-400 font-semibold mb-4 flex items-center gap-2 text-sm uppercase tracking-wider">
          <span class="text-lg">#</span> Key Responsibilities
        </h4>
        <div class="grid gap-3">
          <div
            v-for="(r, idx) in formattedResponsibilities"
            :key="idx"
            class="flex items-start gap-3 group"
          >
            <div class="mt-1 w-5 h-5 bg-purple-500/20 rounded flex items-center justify-center flex-shrink-0 group-hover:bg-purple-500/30 transition-colors">
              <svg class="w-3 h-3 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
              </svg>
            </div>
            <p class="text-gray-300 leading-relaxed flex-1">{{ r }}</p>
          </div>
        </div>
      </div>

      <!-- Tags (Optional) -->
      <div v-if="experience.technologies" class="mt-6 pt-6 border-t border-gray-700/50">
        <div class="flex flex-wrap gap-2">
          <span
            v-for="tech in parseTechnologies(experience.technologies)"
            :key="tech"
            class="px-3 py-1 bg-gray-700/50 text-gray-300 text-xs rounded-full hover:bg-purple-500/20 hover:text-purple-400 transition-colors cursor-default border border-gray-600"
          >
            {{ tech }}
          </span>
        </div>
      </div>
    </div>
  </article>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import type { Experience } from '@/stores/experienceStore';

const props = defineProps<{ experience: Experience & { technologies?: string } }>();

const formatPeriod = (start?: string, end?: string) => {
  if (!start) return '';
  const s = new Date(start).toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
  const e = end ? new Date(end).toLocaleDateString('en-US', { month: 'short', year: 'numeric' }) : 'Present';
  return `${s} - ${e}`;
};

const calculateDuration = (start?: string, end?: string) => {
  if (!start) return '';
  const startDate = new Date(start);
  const endDate = end ? new Date(end) : new Date();
  const months = (endDate.getFullYear() - startDate.getFullYear()) * 12 + (endDate.getMonth() - startDate.getMonth());
  const years = Math.floor(months / 12);
  const remainingMonths = months % 12;
  if (years > 0 && remainingMonths > 0) return `${years} yr ${remainingMonths} mo`;
  if (years > 0) return `${years} yr`;
  return `${remainingMonths} mo`;
};

const formattedResponsibilities = computed(() => {
  const resp = props.experience.responsibilities;
  if (!resp) return [];
  if (Array.isArray(resp)) return resp;
  return (resp as string).split(',').map(r => r.trim()).filter(r => r);
});

const parseTechnologies = (tech?: string) => {
  if (!tech) return [];
  return tech.split(',').map(t => t.trim()).filter(t => t);
};
</script>