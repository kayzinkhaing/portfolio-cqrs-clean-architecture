<template>
  <section class="min-h-screen bg-gray-900 text-white pt-12 pb-20 px-6">
    <div class="max-w-6xl mx-auto space-y-16">
      <!-- Section Header -->
      <SectionTitle
        title="About Me"
        subtitle="Get to know the person behind the code"
      />

      <!-- Grid Layout -->
      <div class="grid lg:grid-cols-2 gap-12 items-start">
        <!-- Left Column -->
        <div class="space-y-8">
          <!-- My Journey -->
          <div
            class="p-8 bg-gray-800/60 border border-gray-700 rounded-2xl hover:border-indigo-500/40 transition-all duration-300"
          >
            <h3 class="text-2xl font-bold text-indigo-300 mb-4">My Journey</h3>
            <p class="text-gray-300 leading-relaxed mb-4">
              Born in Myanmar on March 13, 2001, I discovered my passion for
              technology during my Computer Science studies at the University of
              Computer Studies, Meiktila.
            </p>
            <p class="text-gray-300 leading-relaxed mb-4">
              Since April 2023, I've been working as a Full-Stack Web Developer
              at ITVisionHub, contributing to live projects including charity
              platforms, marketplaces, and restaurant management systems.
            </p>
            <p class="text-indigo-400 italic font-medium">
              "Code with clarity, Deliver with speed, Aim for excellence"
            </p>
          </div>

          <!-- Personal Details -->
          <div
            class="p-8 bg-gray-800/60 border border-gray-700 rounded-2xl hover:border-indigo-500/40 transition-all duration-300"
          >
            <h3 class="text-2xl font-bold text-indigo-300 mb-4">
              Personal Details
            </h3>
            <div class="grid md:grid-cols-2 gap-4">
              <div>
                <p>
                  <span class="text-indigo-400 font-medium">Location:</span>
                  Yangon, Myanmar
                </p>
                <p>
                  <span class="text-indigo-400 font-medium">Languages:</span>
                  Burmese (Native), English
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-8">
          <!-- Stats -->
          <div class="grid grid-cols-2 gap-4">
            <div
              class="p-6 text-center bg-gray-800/60 border border-gray-700 rounded-2xl hover:border-indigo-500/40 transition-all duration-300"
            >
              <div class="text-3xl font-bold text-indigo-400 mb-2">2+</div>
              <div class="text-gray-300">Years Experience</div>
            </div>
            <div
              class="p-6 text-center bg-gray-800/60 border border-gray-700 rounded-2xl hover:border-purple-500/40 transition-all duration-300"
            >
              <div class="text-3xl font-bold text-purple-400 mb-2">5+</div>
              <div class="text-gray-300">Projects Completed</div>
            </div>
            <div
              class="p-6 text-center bg-gray-800/60 border border-gray-700 rounded-2xl hover:border-pink-500/40 transition-all duration-300"
            >
              <div class="text-3xl font-bold text-pink-400 mb-2">15+</div>
              <div class="text-gray-300">Technologies</div>
            </div>
            <div
              class="p-6 text-center bg-gray-800/60 border border-gray-700 rounded-2xl hover:border-amber-500/40 transition-all duration-300"
            >
              <div class="text-3xl font-bold text-amber-400 mb-2">100%</div>
              <div class="text-gray-300">Satisfaction Rate</div>
            </div>
          </div>

          <!-- Achievements -->
          <div
            class="p-8 bg-gray-800/60 border border-gray-700 rounded-2xl hover:border-indigo-500/40 transition-all duration-300"
          >
            <h3 class="text-2xl font-bold text-indigo-300 mb-6">
              Key Achievements
            </h3>
            <ul class="space-y-3 text-gray-300">
              <li class="flex items-start">
                <span class="text-indigo-400 mr-3">▸</span> Graduated with
                B.C.Sc in Computer Sciences (2017–2024)
              </li>
              <li class="flex items-start">
                <span class="text-indigo-400 mr-3">▸</span> Volunteer at Meiktila
                IT-Camp (2018)
              </li>
              <li class="flex items-start">
                <span class="text-indigo-400 mr-3">▸</span> Led multiple
                full-stack development projects
              </li>
              <li class="flex items-start">
                <span class="text-indigo-400 mr-3">▸</span> Expert in Laravel,
                Vue.js, and modern web technologies
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
import SectionTitle from '@/components/ui/SectionTitle.vue'
</script>
