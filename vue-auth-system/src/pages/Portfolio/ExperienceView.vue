<template>
  <section class="py-20 px-6 bg-slate-900 min-h-screen">
    <div class="max-w-6xl mx-auto">
      <SectionTitle
        title="Professional Experience"
        subtitle="My journey in web development and software engineering"
        class="mb-16"
      />

      <!-- Loading -->
      <div v-if="loading" class="space-y-12" aria-busy="true">
        <ExperienceSkeleton v-for="n in 2" :key="n" />
      </div>

      <!-- Error -->
      <div v-else-if="error" class="text-center py-20">
        <p class="text-red-400 text-lg">{{ error }}</p>
        <button
          @click="fetchExperiences"
          class="mt-6 px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors"
        >
          Try Again
        </button>
      </div>

      <!-- Empty -->
      <div
        v-else-if="experiences.length === 0"
        class="text-center py-20 text-white"
      >
        No professional experiences yet
      </div>

      <!-- Experiences -->
      <div v-else class="space-y-12">
        <ExperienceItem
          v-for="exp in experiences"
          :key="exp.id"
          :experience="exp"
        />
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import { onMounted, computed } from "vue";
import { experienceStore } from "@/stores/experienceStore";
import SectionTitle from "@/components/ui/SectionTitle.vue";
import ExperienceItem from "@/components/experience/ExperienceItem.vue";
import ExperienceSkeleton from "@/components/experience/ExperienceSkeleton.vue";

// Pinia store
const store = experienceStore();

// Expose reactive values
const experiences = computed(() => store.experiences);
const loading = computed(() => store.loading);
const error = computed(() => store.error);

// Fetch experiences on mount
onMounted(() => store.fetchExperiencesOnce());

// Wrapper function for template usage
const fetchExperiences = () => {
  store.fetchExperiencesOnce();
};
</script>
