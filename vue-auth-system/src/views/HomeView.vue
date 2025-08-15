<template>
  <div class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Hero Section -->
    <div class="relative z-10 max-w-5xl mx-auto px-4 py-16 text-center">
      <!-- Main Heading -->
      <div class="space-y-8 mb-16">
        <h1 class="text-5xl md:text-6xl font-bold tracking-tight text-gray-900 leading-tight">
          <span class="block">Welcome to</span>
          <span class="block text-indigo-600 mt-2">MyBlog Platform</span>
        </h1>
        
        <!-- Subtitle -->
        <p class="text-lg md:text-xl text-gray-700 max-w-2xl mx-auto leading-relaxed">
          Share your stories, connect with readers, and build your digital presence with our modern blogging platform
        </p>
      </div>

      <!-- CTA Section -->
      <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-20">
        <router-link
          to="/blogs"
          class="group inline-flex items-center gap-2 bg-indigo-600 text-white px-8 py-4 rounded-xl text-base font-semibold hover:bg-indigo-700 shadow-lg hover:shadow-indigo-500/25 transition-all duration-300 hover:-translate-y-0.5"
        >
          <span>Start Reading</span>
          <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </router-link>
        
        <button class="inline-flex items-center gap-2 bg-white border-2 border-gray-300 text-gray-700 px-8 py-4 rounded-xl text-base font-semibold hover:border-indigo-300 hover:text-indigo-700 transition-all duration-300 hover:-translate-y-0.5">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
          </svg>
          <span>Browse Topics</span>
        </button>
      </div>

      <!-- Stats Section -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        <div class="text-center">
          <div class="text-3xl font-bold text-gray-900 mb-2">500+</div>
          <div class="text-gray-600">Articles Published</div>
        </div>
        <div class="text-center">
          <div class="text-3xl font-bold text-gray-900 mb-2">10K+</div>
          <div class="text-gray-600">Active Readers</div>
        </div>
        <div class="text-center">
          <div class="text-3xl font-bold text-gray-900 mb-2">50+</div>
          <div class="text-gray-600">Expert Writers</div>
        </div>
      </div>

      <!-- Feature Grid -->
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-4xl mx-auto">
        <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
          <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Easy Writing</h3>
          <p class="text-gray-600 leading-relaxed">Create beautiful posts with our intuitive editor and rich formatting options</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
          <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Engage Readers</h3>
          <p class="text-gray-600 leading-relaxed">Build meaningful connections with your audience through comments and interactions</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-8 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 md:col-span-2 lg:col-span-1">
          <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Track Performance</h3>
          <p class="text-gray-600 leading-relaxed">Monitor your content's reach with detailed analytics and insights</p>
        </div>
      </div>
    </div>

    <!-- Background Elements -->
    <div class="absolute top-20 left-16 w-32 h-32 bg-indigo-200 rounded-full mix-blend-multiply filter blur-xl opacity-40 animate-pulse"></div>
    <div class="absolute bottom-32 right-16 w-40 h-40 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-40 animate-pulse" style="animation-delay: 2s;"></div>
  </div>
</template>