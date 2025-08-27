<!-- src/components/portfolio/PortfolioNav.vue -->
<template>
  <nav class="fixed top-0 left-0 right-0 z-50 glass-nav">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <!-- Logo -->
        <div class="flex-shrink-0">
          <router-link 
            to="/portfolio" 
            class="flex items-center space-x-3 group"
          >
            <!-- Profile Image (Optional) -->
            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-indigo-500/30 group-hover:border-indigo-400/50 transition-colors">
              <img 
                src="@/assets/images/profile1.png" 
                alt="Kay Zin Khaing" 
                class="w-full h-full object-cover"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"
              >
              <!-- Fallback Avatar -->
              <div class="w-full h-full bg-gradient-to-br from-pink-900 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                KZ
              </div>
            </div>
            
            <!-- Name -->
            <div>
              <h1 class="text-xl font-bold gradient-text-animated">
                Kay Zin Khaing
              </h1>
              <p class="text-xs text-slate-400 group-hover:text-slate-300 transition-colors">
                Full-Stack Developer
              </p>
            </div>
          </router-link>
        </div>
        
        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center space-x-1">
          <router-link 
            v-for="item in navItems" 
            :key="item.name"
            :to="item.path"
            class="nav-link group relative"
            active-class="router-link-active"
          >
            <!-- Icon (Optional) -->
            <span class="inline-flex items-center">
              <component 
                :is="item.icon" 
                class="w-4 h-4 mr-2 opacity-70 group-hover:opacity-100 transition-opacity"
                v-if="item.icon"
              />
              {{ item.name }}
            </span>
          </router-link>
        </div>
        
        <!-- Mobile menu button -->
        <div class="md:hidden">
          <button
            @click="toggleMobileMenu"
            class="btn-ghost p-2"
            :class="{ 'bg-slate-800/50': isMobileMenuOpen }"
          >
            <svg 
              class="w-6 h-6 transition-transform duration-300"
              :class="{ 'rotate-90': isMobileMenuOpen }"
              fill="none" 
              stroke="currentColor" 
              viewBox="0 0 24 24"
            >
              <path 
                v-if="!isMobileMenuOpen"
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M4 6h16M4 12h16M4 18h16"
              />
              <path 
                v-else
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>
    
    <!-- Mobile Navigation Menu -->
    <transition
      name="mobile-nav"
      enter-active-class="transition-all duration-300 ease-out"
      leave-active-class="transition-all duration-200 ease-in"
      enter-from-class="opacity-0 transform -translate-y-2"
      enter-to-class="opacity-100 transform translate-y-0"
      leave-from-class="opacity-100 transform translate-y-0"
      leave-to-class="opacity-0 transform -translate-y-2"
    >
      <div 
        v-if="isMobileMenuOpen" 
        class="md:hidden glass-card border-t border-slate-700/50 mt-1 mx-4 rounded-lg"
      >
        <div class="px-2 pt-2 pb-3 space-y-1">
          <router-link
            v-for="item in navItems"
            :key="item.name"
            :to="item.path"
            @click="closeMobileMenu"
            class="nav-link block text-center py-3"
            active-class="router-link-active"
          >
            <span class="inline-flex items-center">
              <component 
                :is="item.icon" 
                class="w-4 h-4 mr-2"
                v-if="item.icon"
              />
              {{ item.name }}
            </span>
          </router-link>
          
          <!-- Contact Info for Mobile -->
          <div class="pt-4 mt-4 border-t border-slate-700/50">
            <div class="text-center text-sm text-slate-400">
              <p class="mb-2">Let's Connect!</p>
              <div class="flex justify-center space-x-4">
                <a 
                  href="https://github.com/kayzinkhaing" 
                  target="_blank"
                  class="hover:text-indigo-400 transition-colors"
                  title="GitHub"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 0C5.374 0 0 5.373 0 12 0 17.302 3.438 21.8 8.207 23.387c.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                  </svg>
                </a>
                <a 
                  href="https://www.linkedin.com/in/kay-zin-khaing-679109315/" 
                  target="_blank"
                  class="hover:text-indigo-400 transition-colors"
                  title="LinkedIn"
                >
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                  </svg>
                </a>
                <a 
                  href="mailto:kayzinkhaing1331@gmail.com"
                  class="hover:text-indigo-400 transition-colors"
                  title="Email"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
    
    <!-- Backdrop for mobile menu -->
    <div 
      v-if="isMobileMenuOpen" 
      @click="closeMobileMenu"
      class="fixed inset-0 bg-black/20 backdrop-blur-sm md:hidden"
      style="top: 4rem;"
    ></div>
  </nav>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'

// Icons (you can use Lucide icons if available, or simple SVGs)
interface NavItem {
  name: string
  path: string
  icon?: any
}

const router = useRouter()
const isMobileMenuOpen = ref(false)

// Navigation items
const navItems: NavItem[] = [
  { name: 'Home', path: '/portfolio' },
  { name: 'About', path: '/portfolio/about' },
  { name: 'Skills', path: '/portfolio/skills' },
  { name: 'Education', path: '/portfolio/education' },
  { name: 'Work', path: '/portfolio/work' },
  { name: 'Experience', path: '/portfolio/experience' },
  { name: 'Hire Me', path: '/portfolio/hire-me' }
]

// Mobile menu functions
const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false
}

// Close mobile menu when route changes
router.beforeEach(() => {
  closeMobileMenu()
})

// Close mobile menu when clicking outside or pressing escape
const handleClickOutside = (event: Event) => {
  const target = event.target as HTMLElement
  if (!target.closest('nav') && isMobileMenuOpen.value) {
    closeMobileMenu()
  }
}

const handleKeyDown = (event: KeyboardEvent) => {
  if (event.key === 'Escape' && isMobileMenuOpen.value) {
    closeMobileMenu()
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
  document.addEventListener('keydown', handleKeyDown)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
  document.removeEventListener('keydown', handleKeyDown)
})

// Smooth scroll to sections (if needed for single-page navigation)
const scrollToSection = (sectionId: string) => {
  const element = document.getElementById(sectionId)
  if (element) {
    element.scrollIntoView({ behavior: 'smooth' })
  }
}
</script>

<style scoped>
/* Additional component-specific styles if needed */
.router-link-active {
  @apply text-indigo-400 bg-indigo-500 bg-opacity-20;
}



/* Ensure mobile menu appears above other content */
.glass-nav {
  position: relative;
  z-index: 1000;
}

/* Smooth transitions for mobile menu */
.mobile-nav-enter-active,
.mobile-nav-leave-active {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.mobile-nav-enter-from,
.mobile-nav-leave-to {
  opacity: 0;
  transform: translateY(-10px) scale(0.95);
}

/* Logo hover effect */
.group:hover .gradient-text-animated {
  background-size: 200% 200%;
  animation: gradient-shift 2s ease infinite;
}
</style>