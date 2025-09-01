<template>
  <section class="mt-20">
    <!-- Section Title -->
    <h3 class="text-3xl font-bold text-white text-center mb-12">
      Continuous Learning
    </h3>

    <!-- Learning Cards -->
    <div class="grid md:grid-cols-2 gap-8 mb-16">
      <LearningCard
        title="Self-Directed Learning"
        icon-gradient="from-blue-500 to-cyan-500"
        :items="selfDirected"
      />
      <LearningCard
        title="Practical Application"
        icon-gradient="from-green-500 to-emerald-500"
        :items="practical"
      />
    </div>

    <!-- Learning Philosophy -->
    <div class="text-center">
      <div class="glass-card p-8 max-w-3xl mx-auto">
        <h4 class="text-2xl font-bold text-white mb-4">Learning Philosophy</h4>
        <p class="text-lg text-white italic">
          {{ philosophy }}
        </p>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import LearningCard from '@/components/education/LearningCard.vue'

const selfDirected = [
  'Modern JavaScript frameworks and libraries',
  'Cloud platforms and deployment strategies',
  'DevOps practices and CI/CD pipelines',
  'Advanced Laravel features and patterns'
]

const practical = [
  'Real-world project development at ITVisionHub',
  'Open-source contributions and personal projects',
  'Team collaboration and code review practices',
  'Client requirement analysis and solution design'
]

const philosophy =
  'I believe in continuous learning and staying updated with the latest technologies. ' +
  'My analytical thinking and eagerness to learn new technologies help me solve real-world problems effectively.'
</script>

<style scoped>
/* Optional: spacing and animation tweaks */
</style>
