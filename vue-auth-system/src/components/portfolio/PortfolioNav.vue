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
            :class="['nav-link group relative', isActive(item.path) ? 'router-link-active' : '']"
          >
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
            :class="['nav-link group relative', isActive(item.path) ? 'router-link-active' : '']"
            @click="closeMobileMenu"
          >
            <span class="inline-flex items-center">
              <component 
                :is="item.icon" 
                class="w-4 h-4 mr-2 opacity-70 group-hover:opacity-100 transition-opacity"
                v-if="item.icon"
              />
              {{ item.name }}
            </span>
          </router-link>
          
          <!-- Mobile contact info omitted for brevity -->
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
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()
const isMobileMenuOpen = ref(false)

interface NavItem {
  name: string
  path: string
  icon?: any
}

const navItems: NavItem[] = [
  { name: 'Home', path: '/portfolio' },
  { name: 'About', path: '/portfolio/about' },
  { name: 'Skills', path: '/portfolio/skills' },
  { name: 'Education', path: '/portfolio/education' },
  { name: 'Work', path: '/portfolio/work' },
  { name: 'Experience', path: '/portfolio/experience' },
  { name: 'Site Technologies', path: '/portfolio/site-technologies' },
  { name: 'Hire Me', path: '/portfolio/hire-me' }
]

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false
}

// Exact match for active link
const isActive = (path: string) => route.path === path

// Close mobile menu on route change
router.beforeEach(() => {
  closeMobileMenu()
})

const handleClickOutside = (event: Event) => {
  const target = event.target as HTMLElement
  if (!target.closest('nav') && isMobileMenuOpen.value) closeMobileMenu()
}

const handleKeyDown = (event: KeyboardEvent) => {
  if (event.key === 'Escape' && isMobileMenuOpen.value) closeMobileMenu()
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
  document.addEventListener('keydown', handleKeyDown)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
  document.removeEventListener('keydown', handleKeyDown)
})
</script>

<style scoped>
.router-link-active {
  @apply text-indigo-400 bg-opacity-20;
}

.glass-nav { position: relative; z-index: 1000; }

.mobile-nav-enter-active,
.mobile-nav-leave-active { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
.mobile-nav-enter-from,
.mobile-nav-leave-to { opacity: 0; transform: translateY(-10px) scale(0.95); }

.group:hover .gradient-text-animated {
  background-size: 200% 200%;
  animation: gradient-shift 2s ease infinite;
}
</style>
