<template>
  <div class="min-h-screen flex items-center justify-center px-6">
    <!-- Hero Section -->
    <div
      class="max-w-4xl mx-auto flex flex-col md:flex-row items-center text-center md:text-left gap-12"
    >
      <!-- Left: Profile Image -->
      <div class="relative mb-8 md:mb-0 md:w-1/2 flex justify-center">
        <div
          class="w-90 h-90 rounded-full overflow-hidden border-4 border-indigo-500/30 shadow-2xl"
          style="aspect-ratio: 1/1"
        >
          <img
            src="/images/profile1.avif"
            alt="Kay Zin Khaing"
            width="400"
            height="400"
            loading="lazy"
            class=""
            decoding="async"
          />
        </div>
      </div>

      <!-- Right: Content -->
      <div class="md:w-1/2">
        <h1 class="text-5xl md:text-5xl font-bold mb-6">
          <span class="block text-white">Hi, I'm</span>
          <span
            class="block bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent typewriter"
          >
            Kay Zin Khaing
          </span>
        </h1>

        <p class="text-5xl md:text-4xl text-white mb-8 animate-fade-in-up">
          Full-Stack Web Developer
        </p>

        <p
          class="text-xl text-white mb-12 max-w-2xl leading-relaxed animate-fade-in-up delay-200"
        >
          Passionate about building scalable, user-centric web applications with
          clean, maintainable code. Currently contributing to real-world
          projects at ITVisionHub in Myanmar.
        </p>

        <div
          class="flex flex-col sm:flex-row gap-4 justify-start animate-fade-in-up delay-400"
        >
          <router-link
            to="/portfolio/work"
            class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-2xl"
          >
            View My Work
          </router-link>

          <router-link
            to="/portfolio/hire-me"
            class="px-8 py-4 border-2 border-indigo-500 text-indigo-400 font-semibold rounded-lg hover:bg-indigo-500 hover:text-white transform hover:scale-105 transition-all duration-300"
          >
            Get In Touch
          </router-link>
        </div>
      </div>
    </div>

    <!-- Scroll Indicator -->
    <div
      class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce"
    >
      <div
        class="w-1 h-16 bg-gradient-to-b from-indigo-400 to-transparent rounded-full"
      ></div>
    </div>
  </div>
</template>
