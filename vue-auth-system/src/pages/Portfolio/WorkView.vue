<template>
  <div class="py-20 px-6">
    <div class="max-w-7xl mx-auto">
      <SectionTitle 
        title="Featured Projects" 
        subtitle="Real-world applications I've built and contributed to"
        class="mb-16"
      />
      
      <!-- Project Grid -->
      <div class="space-y-16">
        <!-- GiveMM Project -->
        <div class="glass-card overflow-hidden">
          <div class="lg:grid lg:grid-cols-2 lg:gap-8">
            <!-- Project Image -->
            <div class="relative">
              <img 
              src="@/assets/images/mm_give.png" 
              alt="GiveMM Platform"
              class="w-full h-full"
              >
            </div>
            
            <!-- Project Details -->
            <div class="p-8">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-3xl font-bold text-white">GiveMM</h3>
                <span class="px-3 py-1 bg-indigo-500/20 text-indigo-400 rounded-full text-sm">
                  Full-Stack
                </span>
              </div>
              
              <p class="text-lg text-indigo-400 mb-4">Charity Crowdfunding Platform</p>
              
              <p class="text-white mb-6 leading-relaxed">
                A full-stack Laravel-based web platform that allows users to launch and manage 
                fundraising campaigns, donate securely, and monitor campaign progress. Built with 
                clean architecture, performance optimization, and scalability in mind.
              </p>
              
              <!-- Key Features -->
              <div class="mb-6">
                <h4 class="text-lg font-semibold text-white mb-3">Key Features</h4>
                <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-white">
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Campaign Management</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Secure Payment Integration</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Real-time Progress Tracking</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Role-based Access Control</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Docker Containerization</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> CI/CD with GitHub Actions</li>
                </ul>
              </div>
              
              <!-- Tech Stack -->
              <div class="mb-6">
                <h4 class="text-lg font-semibold text-white mb-3">Technologies</h4>
                <div class="flex flex-wrap gap-2">
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">Laravel</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">MySQL</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">Docker</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">Redis</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">GitHub Actions</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">DigitalOcean</span>
                </div>
              </div>
              
              <!-- Action Buttons -->
              <div class="flex space-x-4">
                <a 
                  href="https://github.com/ITVHBaseCode/Givemm" 
                  target="_blank"
                  class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105"
                >
                  View Code
                </a>
                <button class="px-6 py-3 border-2 border-indigo-500 text-indigo-400 font-semibold rounded-lg hover:bg-indigo-500 hover:text-white transition-all duration-300">
                  Live Demo
                </button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Daily Fair Deal Project -->
        <div class="glass-card overflow-hidden">
          <div class="lg:grid lg:grid-cols-2 lg:gap-8">
            <!-- Project Image -->
            <div class="relative h-64 lg:h-full lg:order-2">
              <img 
                src="@/assets/images/rideandsavor.png" 
                alt="Daily Fair Deal Platform"
                class="w-full h-full"
              >
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 to-transparent"></div>
            </div>
            
            <!-- Project Details -->
            <div class="p-8 lg:order-1">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-3xl font-bold text-white">Daily Fair Deal</h3>
                <span class="px-3 py-1 bg-purple-500/20 text-purple-400 rounded-full text-sm">
                  Backend
                </span>
              </div>
              
              <p class="text-lg text-purple-400 mb-4">Multi-Service Marketplace</p>
              
              <p class="text-white mb-6 leading-relaxed">
                A comprehensive multi-service marketplace integrating food delivery, e-commerce, 
                and ride-hailing services. Built RESTful APIs serving users, restaurants, shops, 
                and drivers with real-time features and payment integration.
              </p>
              
              <!-- Key Features -->
              <div class="mb-6">
                <h4 class="text-lg font-semibold text-white mb-3">Core Modules</h4>
                <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-white">
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> User Authentication (OTP)</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Restaurant Management</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Order Processing System</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Taxi Booking Service</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Real-time Tracking</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Payment Integration</li>
                </ul>
              </div>
              
              <!-- Tech Stack -->
              <div class="mb-6">
                <h4 class="text-lg font-semibold text-white mb-3">Technologies</h4>
                <div class="flex flex-wrap gap-2">
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">Laravel</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">PHP 8</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">MySQL</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">Laravel Sanctum</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">Stripe</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">PayPal</span>
                </div>
              </div>
              
              <!-- Action Buttons -->
              <div class="flex space-x-4">
                <button class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-semibold rounded-lg hover:from-purple-600 hover:to-pink-700 transition-all duration-300 transform hover:scale-105">
                  View Details
                </button>
                <button class="px-6 py-3 border-2 border-purple-500 text-purple-400 font-semibold rounded-lg hover:bg-purple-500 hover:text-white transition-all duration-300">
                  API Docs
                </button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Real Estate Management Project -->
        <div class="glass-card overflow-hidden">
          <div class="lg:grid lg:grid-cols-2 lg:gap-8">
            <!-- Project Image -->
            <div class="relative h-64 lg:h-full">
              <img 
                src="@/assets/images/realestate.png" 
                alt="Real Estate Management System"
                class="w-full h-full "
              >
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 to-transparent"></div>
            </div>
            
            <!-- Project Details -->
            <div class="p-8">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-3xl font-bold text-white">Real Estate System</h3>
                <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm">
                  Backend API
                </span>
              </div>
              
              <p class="text-lg text-green-400 mb-4">Property Management Platform</p>
              
              <p class="text-white mb-6 leading-relaxed">
                A comprehensive real estate backend system enabling users to register, manage properties, 
                book viewings, and leave reviews. Features secure authentication with social login 
                integration and robust API architecture.
              </p>
              
              <!-- Key Features -->
              <div class="mb-6">
                <h4 class="text-lg font-semibold text-white mb-3">Features</h4>
                <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-white">
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Property Listings</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Social Authentication</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Booking Management</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Review System</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Token-based Auth</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Location Services</li>
                </ul>
              </div>
              
              <!-- Tech Stack -->
              <div class="mb-6">
                <h4 class="text-lg font-semibold text-white mb-3">Technologies</h4>
                <div class="flex flex-wrap gap-2">
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">Laravel 11</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">Laravel Passport</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">Laravel Socialite</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">MySQL</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">RESTful API</span>
                </div>
              </div>
              
              <!-- Action Buttons -->
              <div class="flex space-x-4">
                <button class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-300 transform hover:scale-105">
                  View Code
                </button>
                <button class="px-6 py-3 border-2 border-green-500 text-green-400 font-semibold rounded-lg hover:bg-green-500 hover:text-white transition-all duration-300">
                  Documentation
                </button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Yummy Restaurant Project -->
        <div class="glass-card overflow-hidden">
          <div class="lg:grid lg:grid-cols-2 lg:gap-8">
            <!-- Project Image -->
            <div class="relative h-64 lg:h-full lg:order-2">
              <img 
                src="@/assets/images/yummy.png" 
                alt="Yummy Restaurant System"
                class="w-full h-full "
              >
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 to-transparent"></div>
            </div>
            
            <!-- Project Details -->
            <div class="p-8 lg:order-1">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-3xl font-bold text-white">Yummy Restaurant</h3>
                <span class="px-3 py-1 bg-amber-500/20 text-white text-amber-400 rounded-full text-sm">
                  Full-Stack
                </span>
              </div>
              
              <p class="text-lg text-white text-amber-400 mb-4">Restaurant Management Platform</p>
              
              <p class="text-white mb-6 leading-relaxed">
                A scalable restaurant management platform designed to streamline online ordering 
                for customers and simplify menu/order management for administrators. Features 
                intuitive interfaces for both customer and admin experiences.
              </p>
              
              <!-- Key Features -->
              <div class="mb-6">
                <h4 class="text-lg font-semibold text-white mb-3">Core Features</h4>
                <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-white">
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Menu Browsing</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Category Filtering</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Shopping Cart</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Order Management</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> Admin Dashboard</li>
                  <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> User Management</li>
                </ul>
              </div>
              
              <!-- Tech Stack -->
              <div class="mb-6">
                <h4 class="text-lg font-semibold text-white mb-3">Technologies</h4>
                <div class="flex flex-wrap gap-2">
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">PHP</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">JavaScript</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">Ajax</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">Bootstrap</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">MySQL</span>
                  <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs">MVC Pattern</span>
                </div>
              </div>
              
              <!-- Action Buttons -->
              <div class="flex space-x-4">
                <button class="px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-semibold rounded-lg hover:from-amber-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105">
                  View Project
                </button>
                <button class="px-6 py-3 text-white border-2 border-amber-500 text-amber-400 font-semibold rounded-lg hover:bg-amber-500 hover:text-black transition-all duration-300">
                  Case Study
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Additional Projects Section -->
      <div class="mt-20">
        <h3 class="text-3xl font-bold text-white text-center mb-12">Other Notable Projects</h3>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Personal Portfolio -->
          <div class="glass-card p-6 hover:scale-105 transition-transform duration-300">
            <div class="w-full h-48 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg mb-4 flex items-center justify-center">
              <span class="text-4xl">🌐</span>
            </div>
            <h4 class="text-xl font-bold text-white mb-2">Personal Portfolio</h4>
            <p class="text-white mb-4">Modern Vue.js portfolio showcasing skills and projects</p>
            <div class="flex flex-wrap gap-2 mb-4">
              <span class="px-2 py-1 bg-slate-700 text-xs text-white rounded">Vue.js</span>
              <span class="px-2 py-1 bg-slate-700 text-xs text-white rounded">TailwindCSS</span>
            </div>
            <a href="https://kayzinkhaing.github.io/my-portfolio/" target="_blank" class="text-indigo-400 hover:text-indigo-300 transition-colors">
              View Live →
            </a>
          </div>
          
          <!-- Open Source Contributions -->
          <div class="glass-card p-6 hover:scale-105 transition-transform duration-300">
            <div class="w-full h-48 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg mb-4 flex items-center justify-center">
              <span class="text-4xl">🔧</span>
            </div>
            <h4 class="text-xl font-bold text-white mb-2">Open Source</h4>
            <p class="text-white mb-4">Contributing to Laravel packages and PHP libraries</p>
            <div class="flex flex-wrap gap-2 mb-4">
              <span class="px-2 py-1 bg-slate-700 text-xs text-white rounded">Laravel</span>
              <span class="px-2 py-1 bg-slate-700 text-xs text-white rounded">PHP</span>
            </div>
            <a href="https://github.com/kayzinkhaing" target="_blank" class="text-green-400 hover:text-green-300 transition-colors">
              View GitHub →
            </a>
          </div>
          
          <!-- Learning Projects -->
          <div class="glass-card p-6 hover:scale-105 transition-transform duration-300">
            <div class="w-full h-48 bg-gradient-to-br from-pink-500 to-rose-600 rounded-lg mb-4 flex items-center justify-center">
              <span class="text-4xl">📚</span>
            </div>
            <h4 class="text-xl font-bold text-white mb-2">Learning Projects</h4>
            <p class="text-white mb-4">Experimental apps exploring new technologies</p>
            <div class="flex flex-wrap gap-2 mb-4">
              <span class="px-2 py-1 bg-slate-700 text-xs text-white rounded">Various</span>
              <span class="px-2 py-1 bg-slate-700 text-xs text-white rounded">Experiments</span>
            </div>
            <span class="text-pink-400">In Development</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>