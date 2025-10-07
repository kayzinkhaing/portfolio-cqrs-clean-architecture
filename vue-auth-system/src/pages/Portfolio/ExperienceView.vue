<template>
  <section class="min-h-screen bg-gray-900 py-20 px-6">
    <div class="max-w-6xl mx-auto">
      <SectionTitle
        title="Professional Experience"
        subtitle="My journey in web development and software engineering"
        class="mb-16"
      />

      <!-- Loading -->
      <div v-if="loading" class="text-center py-20">
        <div class="inline-block w-16 h-16 border-4 border-purple-500 border-t-transparent rounded-full animate-spin"></div>
        <p class="text-gray-400 mt-4">Loading experiences...</p>
      </div>

      <!-- Error -->
      <div v-else-if="error" class="text-center py-20">
        <div class="text-6xl mb-4">⚠️</div>
        <h3 class="text-2xl font-bold text-white mb-2">Oops! Something went wrong</h3>
        <p class="text-gray-400 mb-6">{{ error }}</p>
        <button
          @click="fetchExperiences"
          class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition-colors"
        >
          Try Again
        </button>
      </div>

      <!-- Empty -->
      <div v-else-if="experiences.length === 0" class="text-center py-20">
        <div class="text-6xl mb-4">💼</div>
        <h3 class="text-2xl font-bold text-white mb-2">No experiences to show</h3>
        <p class="text-gray-400">Check back later for updates</p>
      </div>

      <!-- Experience List -->
      <div v-else class="space-y-6">
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

const store = experienceStore();

const experiences = computed(() => store.experiences);
const loading = computed(() => store.loading);
const error = computed(() => store.error);

const fetchExperiences = () => store.fetchExperiencesOnce();

onMounted(() => store.fetchExperiencesOnce());
</script>
