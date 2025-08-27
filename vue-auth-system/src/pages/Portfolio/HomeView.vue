<template>
  <div class="min-h-screen flex items-center justify-center px-6">
    <!-- Hero Section -->
    <div class="max-w-4xl mx-auto flex flex-col md:flex-row items-center text-center md:text-left gap-12 p-0 m-0">
      <!-- Left: Profile Image with Floating Animation -->
      <div class="relative mb-8 md:mb-0 md:w-1/2 flex justify-center p-0 m-0">
      <div class="w-90 h-90 rounded-full overflow-hidden border-4 border-indigo-500/30 shadow-2xl animate-float">
        <img src="@/assets/images/profile1.png" alt="Kay Zin Khaing" class="w-full h-full object-cover">
      </div>
      <!-- Animated Ring -->
      <!-- <div class="absolute inset-0 rounded-full border-2 border-indigo-400/50 animate-ping"></div> -->
      </div>

      <!-- Right: Content -->
      <div class="md:w-1/2 p-0 m-0">
      <!-- Main Heading with Typewriter Effect -->
      <h1 class="text-5xl md:text-5xl font-bold mb-6">
        <span class="block text-white">Hi, I'm</span>
        <span class="block bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent typewriter">
        Kay Zin Khaing
        </span>
      </h1>
      
      <!-- Subtitle -->
      <p class="text-5xl md:text-4xl text-white mb-8 animate-fade-in-up">
        Full-Stack Web Developer
      </p>
      
      <!-- Description -->
      <p class="text-xl text-white mb-12 max-w-2xl leading-relaxed animate-fade-in-up delay-200">
        Passionate about building scalable, user-centric web applications with clean, maintainable code. 
        Currently contributing to real-world projects at ITVisionHub in Myanmar.
      </p>
      
      <!-- CTA Buttons -->
      <div class="flex flex-col sm:flex-row gap-4 justify-start animate-fade-in-up delay-400 p-0 m-0">
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
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
      <div class="w-1 h-16 bg-gradient-to-b from-indigo-400 to-transparent rounded-full"></div>
    </div>
  </div>
</template>