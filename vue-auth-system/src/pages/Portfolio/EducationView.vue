<template>
  <section
    class="py-20 px-6 min-h-screen flex items-center justify-center bg-slate-900"
  >
    <div class="max-w-4xl w-full">
      <!-- Full-page Loading -->
      <div v-if="loading" class="space-y-12" aria-busy="true" role="status">
        <TimelineItemSkeleton v-for="n in 3" :key="n" />
        <span class="sr-only">Loading education timeline...</span>
      </div>

      <!-- Error -->
      <div v-else-if="error" class="text-center py-20">
        <p class="text-red-400 text-lg">{{ error }}</p>
        <button
          @click="fetchEducationsOnce"
          class="mt-6 px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors"
        >
          Try Again
        </button>
      </div>

      <!-- Empty -->
      <div v-else-if="educations.length === 0" class="text-center py-20">
        <p class="text-slate-400 text-lg">No education records available yet</p>
      </div>

      <!-- Education Content -->
      <div v-else>
        <!-- Section Title -->
        <SectionTitle
          title="Education & Learning"
          subtitle="My academic journey and continuous learning path"
          class="mb-16"
        />

        <!-- Timeline -->
        <div class="relative">
          <div
            class="absolute top-0 bottom-0 w-0.5 bg-gradient-to-b from-indigo-500 via-purple-500 to-pink-500 left-6"
          ></div>

          <transition-group name="fade" tag="div" class="space-y-12">
            <TimelineItem
              v-for="edu in educations"
              :key="edu.id"
              :year="formatYear(edu.start_date, edu.end_date)"
              :title="edu.degree"
              :subtitle="edu.institution"
              highlight
            >
              <div class="space-y-4">
                <p class="text-white">{{ edu.details }}</p>
                <div v-if="edu.location" class="text-indigo-400 text-sm">
                  📍 {{ edu.location }}
                </div>
              </div>
            </TimelineItem>
          </transition-group>
        </div>

        <ContinuousLearning />
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { onMounted, computed } from "vue";
import SectionTitle from "@/components/ui/SectionTitle.vue";
import TimelineItem from "@/components/ui/TimelineItem.vue";
import TimelineItemSkeleton from "@/components/ui/TimelineItemSkeleton.vue";
import {
  educationStore,
  fetchEducationsOnce,
  Education,
} from "@/stores/educationStore";
import ContinuousLearning from "@/components/education/ContinuousLearning.vue";

// Use computed to stay reactive with store
const educations = computed(() => educationStore.educations);
const loading = computed(() => educationStore.loading);
const error = computed(() => educationStore.error);

// Fetch once on mount
onMounted(fetchEducationsOnce);

// Format year for timeline
const formatYear = (start?: string, end?: string) => {
  const startYear = start ? String(new Date(start).getFullYear()) : "";
  const endYear = end ? String(new Date(end).getFullYear()) : "";
  return startYear && endYear
    ? `${startYear} - ${endYear}`
    : startYear || endYear || "";
};
</script>

<style scoped>
/* Fade transition for timeline items */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>
