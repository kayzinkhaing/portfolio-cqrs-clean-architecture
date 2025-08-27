<!-- src/components/portfolio/PortfolioFooter.vue -->
<template>
  <footer class="relative z-10 mt-20">
    <div class="glass-card mx-6 mb-6 rounded-2xl">
      <div class="max-w-6xl mx-auto px-8 py-12">
        <!-- Main Footer Content -->
        <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-8 mb-8">
          <!-- About Section -->
          <div class="lg:col-span-2">
            <div class="flex items-center space-x-3 mb-4">
              <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-indigo-500/30">
                <img 
                  src="@/assets/images/profile1.png" 
                  alt="Kay Zin Khaing" 
                  class="w-full h-full object-cover"
                  onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"
                >
                <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold">
                  KZ
                </div>
              </div>
              <div>
                <h3 class="text-xl font-bold gradient-text">Kay Zin Khaing</h3>
                <p class="text-white text-sm">Full-Stack Web Developer</p>
              </div>
            </div>
            <p class="text-white leading-relaxed mb-6 max-w-md">
              Passionate about building scalable, user-centric web applications with clean, 
              maintainable code. Currently contributing to real-world projects at ITVisionHub in Myanmar.
            </p>
            
            <!-- Social Links -->
            <div class="flex space-x-4">
              <a 
                href="https://github.com/kayzinkhaing" 
                target="_blank"
                class="w-10 h-10 bg-slate-800/50 hover:bg-indigo-500/20 rounded-lg flex items-center justify-center text-white hover:text-indigo-400 transition-all duration-300 hover:scale-110"
                title="GitHub"
              >
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 0C5.374 0 0 5.373 0 12 0 17.302 3.438 21.8 8.207 23.387c.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                </svg>
              </a>
              
              <a 
                href="https://www.linkedin.com/in/kay-zin-khaing-679109315/" 
                target="_blank"
                class="w-10 h-10 bg-slate-800/50 hover:bg-blue-500/20 rounded-lg flex items-center justify-center text-white hover:text-blue-400 transition-all duration-300 hover:scale-110"
                title="LinkedIn"
              >
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
              </a>
              
              <a 
                href="mailto:kayzinkhaing1331@gmail.com"
                class="w-10 h-10 bg-slate-800/50 hover:bg-red-500/20 rounded-lg flex items-center justify-center text-white hover:text-red-400 transition-all duration-300 hover:scale-110"
                title="Email"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
              </a>
              
              <a 
                href="https://kayzinkhaing.github.io/my-portfolio/" 
                target="_blank"
                class="w-10 h-10 bg-slate-800/50 hover:bg-purple-500/20 rounded-lg flex items-center justify-center text-white hover:text-purple-400 transition-all duration-300 hover:scale-110"
                title="Portfolio Website"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9m0 9c-5 0-9-4-9-9s4-9 9-9"/>
                </svg>
              </a>
            </div>
          </div>
          
          <!-- Quick Links -->
          <div>
            <h4 class="text-lg font-semibold text-white mb-4">Quick Links</h4>
            <ul class="space-y-2">
              <li>
                <router-link 
                  to="/portfolio" 
                  class="text-white hover:text-indigo-400 transition-colors text-sm"
                >
                  Home
                </router-link>
              </li>
              <li>
                <router-link 
                  to="/portfolio/about" 
                  class="text-white hover:text-indigo-400 transition-colors text-sm"
                >
                  About Me
                </router-link>
              </li>
              <li>
                <router-link 
                  to="/portfolio/skills" 
                  class="text-white hover:text-indigo-400 transition-colors text-sm"
                >
                  Skills
                </router-link>
              </li>
              <li>
                <router-link 
                  to="/portfolio/work" 
                  class="text-white hover:text-indigo-400 transition-colors text-sm"
                >
                  Projects
                </router-link>
              </li>
              <li>
                <router-link 
                  to="/portfolio/hire-me" 
                  class="text-white hover:text-indigo-400 transition-colors text-sm"
                >
                  Hire Me
                </router-link>
              </li>
            </ul>
          </div>
          
          <!-- Contact Info -->
          <div>
            <h4 class="text-lg font-semibold text-white mb-4">Get In Touch</h4>
            <ul class="space-y-3">
              <li class="flex items-center text-white text-sm">
                <svg class="w-4 h-4 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                +959 762 194 708
              </li>
              <li class="flex items-center text-white text-sm">
                <svg class="w-4 h-4 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                kayzinkhaing1331@gmail.com
              </li>
              <li class="flex items-center text-white text-sm">
                <svg class="w-4 h-4 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Yangon, Myanmar
              </li>
              <li class="flex items-start text-white text-sm">
                <svg class="w-4 h-4 mr-3 mt-0.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                  <div>Available for opportunities</div>
                  <div class="text-xs text-white mt-1">2 weeks notice period</div>
                </div>
              </li>
            </ul>
          </div>
        </div>
        
        <!-- Divider -->
        <div class="border-t border-slate-700/50 pt-8">
          <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <!-- Copyright -->
            <div class="text-white text-sm text-center md:text-left">
              <p>&copy; {{ currentYear }} Kay Zin Khaing. All rights reserved.</p>
              <p class="text-xs text-white mt-1">
                Built with ❤️ using Vue.js, TypeScript & TailwindCSS
              </p>
            </div>
            
            <!-- Download CV Button -->
            <div class="flex items-center space-x-4">
              <button
                @click="downloadCV"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-indigo-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-300"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download CV
              </button>
              
              <!-- Back to Top -->
              <button
                @click="scrollToTop"
                class="w-10 h-10 bg-slate-800/50 hover:bg-indigo-500/20 rounded-lg flex items-center justify-center text-slate-400 hover:text-indigo-400 transition-all duration-300 hover:scale-110"
                title="Back to Top"
              >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const currentYear = computed(() => new Date().getFullYear())

const downloadCV = () => {
  // You can link this to your actual CV file
  const link = document.createElement('a')
  link.href = '/Kay-Zin-Khaing-CV.pdf' // Place your CV in the public folder
  link.download = 'Kay-Zin-Khaing-CV.pdf'
  link.click()
}

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  })
}
</script>

<style scoped>
/* Additional styling if needed */
.gradient-text {
  background: linear-gradient(135deg, #6366f1, #8b5cf6, #ec4899);
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
</style>