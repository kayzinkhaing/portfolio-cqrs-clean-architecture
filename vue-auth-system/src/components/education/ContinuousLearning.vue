<template>
  <section class="mt-24">
    <!-- Section Title -->
    <div class="text-center mb-16">
      <h3
        class="text-4xl font-extrabold bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent"
      >
        Continuous Learning
      </h3>
      <p class="mt-3 text-gray-400 text-lg">
        Exploring new ideas, sharpening skills, and applying knowledge in real-world scenarios.
      </p>
    </div>

    <!-- Learning Cards -->
    <div class="grid md:grid-cols-2 gap-10 mb-20">
      <!-- Self-Directed Learning -->
      <div
        class="p-8 bg-gray-800/60 border border-gray-700 rounded-2xl hover:border-indigo-500/40 hover:shadow-xl transition-all duration-300"
      >
        <div class="flex items-center mb-6">
          <div
            class="w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-2xl font-bold shadow-md"
          >
            📘
          </div>
          <h4 class="ml-4 text-2xl font-bold text-indigo-300">
            Self-Directed Learning
          </h4>
        </div>
        <ul class="space-y-3 text-gray-300">
          <li
            v-for="(item, index) in selfDirected"
            :key="index"
            class="flex items-start"
          >
            <span class="text-indigo-400 mr-3">▸</span>
            {{ item }}
          </li>
        </ul>
      </div>

      <!-- Practical Application -->
      <div
        class="p-8 bg-gray-800/60 border border-gray-700 rounded-2xl hover:border-green-500/40 hover:shadow-xl transition-all duration-300"
      >
        <div class="flex items-center mb-6">
          <div
            class="w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-r from-green-500 to-emerald-500 text-white text-2xl font-bold shadow-md"
          >
            ⚙️
          </div>
          <h4 class="ml-4 text-2xl font-bold text-green-300">
            Practical Application
          </h4>
        </div>
        <ul class="space-y-3 text-gray-300">
          <li
            v-for="(item, index) in practical"
            :key="index"
            class="flex items-start"
          >
            <span class="text-green-400 mr-3">▸</span>
            {{ item }}
          </li>
        </ul>
      </div>
    </div>

    <!-- Learning Philosophy -->
    <div
      class="max-w-3xl mx-auto text-center p-10 bg-gray-800/60 border border-gray-700 rounded-2xl hover:border-pink-500/40 hover:shadow-lg transition-all duration-300"
    >
      <h4
        class="text-2xl font-bold bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent mb-4"
      >
        Learning Philosophy
      </h4>
      <p class="text-lg text-gray-300 italic leading-relaxed">
        {{ philosophy }}
      </p>
    </div>
  </section>
</template>

<script setup lang="ts">
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
  'I believe in lifelong learning — embracing challenges, adapting to new technologies, ' +
  'and continuously refining my craft to build reliable and impactful solutions.'
</script>
