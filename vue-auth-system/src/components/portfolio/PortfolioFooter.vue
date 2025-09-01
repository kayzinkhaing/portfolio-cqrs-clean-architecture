<!-- src/components/portfolio/PortfolioFooter.vue -->
<template>
  <footer class="bg-gray-900 text-gray-200 mt-20">
    <div class="max-w-7xl mx-auto px-6">
      <div class="border-t border-gray-700 mb-8"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-12">
      <!-- Main Footer Grid -->
      <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-10 mb-10">
        
        <!-- About Section -->
        <div class="lg:col-span-2">
          <div class="flex items-center mb-4">
            <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0 border border-gray-700">
              <img
                src="@/assets/images/profile1.png"
                alt="Kay Zin Khaing"
                class="w-full h-full object-cover"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"
              />
              <div class="w-full h-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                KZ
              </div>
            </div>
            <div class="ml-3">
              <h3 class="text-lg font-semibold">Kay Zin Khaing</h3>
              <p class="text-sm text-gray-400">Full-Stack Web Developer</p>
            </div>
          </div>
          <p class="text-gray-400 leading-relaxed mb-6 max-w-md">
            Passionate about building scalable, user-centric web applications with clean, maintainable code.
            Currently contributing to real-world projects at ITVisionHub in Myanmar.
          </p>
          
          <!-- Social Links -->
          <div class="flex space-x-3">
            <SocialLink
              v-for="link in socialLinks"
              :key="link.title"
              :url="link.url"
              :icon="link.icon"
              :title="link.title"
            />
          </div>
        </div>

        <!-- Quick Links -->
        <div>
          <h4 class="text-sm font-semibold text-gray-400 mb-4 uppercase tracking-wider">
            Quick Links
          </h4>
          <ul class="space-y-2">
            <li v-for="link in quickLinks" :key="link.name" class="relative group">
              <router-link 
                :to="link.path"
                class="text-gray-300 text-sm transition-colors pl-4 hover:text-indigo-500"
              >
                {{ link.name }}
              </router-link>
              <!-- subtle left border on hover -->
              <span class="absolute left-0 top-0 h-full w-0.5 bg-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity rounded"></span>
            </li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div>
          <h4 class="text-sm font-semibold text-gray-300 mb-4 uppercase">Contact</h4>
          <ul class="space-y-3 text-gray-400 text-sm">
            <li class="flex items-center">
              <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
              </svg>
              +959 762 194 708
            </li>
            <li class="flex items-center">
              <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
              kayzinkhaing1331@gmail.com
            </li>
            <li class="flex items-center">
              <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              Yangon, Myanmar
            </li>
          </ul>
        </div>
      </div>

      <!-- Footer Bottom -->
      <div class="border-t border-gray-700 pt-6">
  <p class="text-gray-500 text-sm text-center">
    &copy; {{ currentYear }} Kay Zin Khaing. All rights reserved.
  </p>
</div>

    </div>
  </footer>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import SocialLink from './SocialLink.vue' // Import as separate component

const currentYear = computed(() => new Date().getFullYear())

const socialLinks = [
  {
    url: "https://github.com/kayzinkhaing",
    icon: "github" as const,
    title: "GitHub"
  },
  {
    url: "https://www.linkedin.com/in/kay-zin-khaing-679109315/",
    icon: "linkedin" as const, 
    title: "LinkedIn"
  },
  {
    url: "mailto:kayzinkhaing1331@gmail.com",
    icon: "mail" as const,
    title: "Email"
  },
  {
    url: "https://kayzinkhaing.github.io/my-portfolio/",
    icon: "portfolio" as const,
    title: "Portfolio"
  }
] as const

const quickLinks = [
  { name: 'Home', path: '/portfolio' },
  { name: 'About', path: '/portfolio/about' },
  { name: 'Skills', path: '/portfolio/skills' },
  { name: 'Projects', path: '/portfolio/work' },
  { name: 'Hire Me', path: '/portfolio/hire-me' },
]

</script>
