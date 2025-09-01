<!-- src/pages/Portfolio/SiteTechnologiesView.vue -->
<template>
  <div class="py-20 px-6">
    <div class="max-w-6xl mx-auto">
      <SectionTitle 
        title="Site Technologies" 
        subtitle="Technologies powering this portfolio website"
        class="mb-16"
      />

      <!-- Architecture Overview -->
      <div class="glass-card p-8 mb-12">
        <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
          <span class="bg-gradient-to-r from-indigo-500 to-purple-500 w-8 h-8 rounded mr-3 flex items-center justify-center">
            🏗️
          </span>
          Architecture Overview
        </h3>
        <div class="grid md:grid-cols-2 gap-8">
          <div>
            <h4 class="text-lg font-semibold text-white mb-3">Frontend Stack</h4>
            <p class="text-gray-300 leading-relaxed">
              Built with Vue.js 3 and TypeScript for type safety and maintainability. 
              Styled using TailwindCSS for rapid development and consistent design system.
            </p>
          </div>
          <div>
            <h4 class="text-lg font-semibold text-white mb-3">Development Tools</h4>
            <p class="text-gray-300 leading-relaxed">
              Vite for blazing-fast development experience, Git for version control, 
              and modern deployment practices for optimal performance.
            </p>
          </div>
        </div>
      </div>

      <!-- Technology Stack -->
      <div class="space-y-8">
        <div 
          v-for="category in techStack" 
          :key="category.title"
          class="glass-card p-8"
        >
          <h3 class="text-2xl font-bold text-white mb-8 flex items-center">
            <span :class="category.iconClass" class="w-8 h-8 rounded mr-3 flex items-center justify-center">
              {{ category.icon }}
            </span>
            {{ category.title }}
          </h3>
          
          <div class="grid lg:grid-cols-2 gap-6">
            <TechnologyCard 
              v-for="tech in category.technologies" 
              :key="tech.name"
              :name="tech.name"
              :version="tech.version"
              :purpose="tech.purpose"
              :features="tech.features"
              :color="tech.color"
            />
          </div>
        </div>
      </div>

      <!-- Performance Metrics -->
      <div class="mt-16 glass-card p-8">
        <h3 class="text-2xl font-bold text-white mb-8 text-center">Performance & Best Practices</h3>
        <div class="grid md:grid-cols-4 gap-6">
          <div 
            v-for="metric in performanceMetrics" 
            :key="metric.label"
            class="text-center group"
          >
            <div :class="metric.bgClass" class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
              <span class="text-2xl font-bold text-white">{{ metric.value }}</span>
            </div>
            <h4 class="text-white font-semibold mb-2">{{ metric.label }}</h4>
            <p class="text-gray-400 text-sm">{{ metric.description }}</p>
          </div>
        </div>
      </div>

      <!-- Implementation Details -->
      <div class="mt-16 glass-card p-8">
        <h3 class="text-2xl font-bold text-white mb-8">Implementation Highlights</h3>
        <div class="grid md:grid-cols-2 gap-8">
          <div 
            v-for="feature in implementationFeatures" 
            :key="feature.title"
            class="border-l-4 border-indigo-500 pl-6"
          >
            <h4 class="text-lg font-semibold text-white mb-3">{{ feature.title }}</h4>
            <p class="text-gray-300 mb-3">{{ feature.description }}</p>
            <div class="flex flex-wrap gap-2">
              <span 
                v-for="tech in feature.techUsed" 
                :key="tech"
                class="px-3 py-1 bg-gray-800 text-gray-300 text-sm rounded-full"
              >
                {{ tech }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import SectionTitle from "@/components/portfolio/SectionTitle.vue"
import TechnologyCard from "@/components/portfolio/TechnologyCard.vue"

interface Technology {
  name: string
  version: string
  purpose: string
  features: string[]
  color: string
}

interface TechCategory {
  title: string
  icon: string
  iconClass: string
  technologies: Technology[]
}

interface PerformanceMetric {
  label: string
  value: string
  description: string
  bgClass: string
}

interface ImplementationFeature {
  title: string
  description: string
  techUsed: string[]
}

const techStack: TechCategory[] = [
  {
    title: "Core Framework",
    icon: "🎯",
    iconClass: "bg-gradient-to-r from-green-500 to-emerald-500",
    technologies: [
      {
        name: "Vue.js",
        version: "3.4.x",
        purpose: "Progressive JavaScript framework for building user interfaces",
        features: ["Composition API", "TypeScript Support", "Reactive Data Binding", "Component-Based Architecture"],
        color: "green"
      },
      {
        name: "TypeScript",
        version: "5.x",
        purpose: "Type-safe JavaScript development",
        features: ["Static Type Checking", "IntelliSense Support", "Better Refactoring", "Enhanced IDE Experience"],
        color: "blue"
      }
    ]
  },
  {
    title: "Styling & UI",
    icon: "🎨",
    iconClass: "bg-gradient-to-r from-pink-500 to-rose-500",
    technologies: [
      {
        name: "TailwindCSS",
        version: "3.x",
        purpose: "Utility-first CSS framework for rapid UI development",
        features: ["Custom Design System", "Responsive Design", "Dark Mode Support", "JIT Compilation"],
        color: "cyan"
      },
      {
        name: "CSS3",
        version: "Latest",
        purpose: "Modern styling with animations and effects",
        features: ["CSS Grid", "Flexbox", "Custom Properties", "Smooth Animations"],
        color: "blue"
      }
    ]
  },
  {
    title: "Development Tools",
    icon: "🛠️",
    iconClass: "bg-gradient-to-r from-orange-500 to-red-500",
    technologies: [
      {
        name: "Vite",
        version: "5.x",
        purpose: "Fast build tool and development server",
        features: ["Hot Module Replacement", "Fast Builds", "ES Modules", "Plugin Ecosystem"],
        color: "purple"
      },
      {
        name: "Vue Router",
        version: "4.x",
        purpose: "Official router for Vue.js applications",
        features: ["SPA Navigation", "Route Guards", "Dynamic Routing", "History Mode"],
        color: "green"
      }
    ]
  },
  {
    title: "State & Data",
    icon: "📊",
    iconClass: "bg-gradient-to-r from-indigo-500 to-blue-500",
    technologies: [
      {
        name: "Pinia",
        version: "2.x",
        purpose: "Official state management for Vue.js",
        features: ["Type Safety", "DevTools Support", "Hot Module Replacement", "Modular Stores"],
        color: "yellow"
      },
      {
        name: "Composables",
        version: "Vue 3",
        purpose: "Reusable stateful logic with Composition API",
        features: ["Code Reusability", "Logic Separation", "Reactive State", "Lifecycle Hooks"],
        color: "green"
      }
    ]
  }
]

const performanceMetrics: PerformanceMetric[] = [
  {
    label: "Performance",
    value: "95+",
    description: "Lighthouse Performance Score",
    bgClass: "bg-gradient-to-r from-green-500 to-emerald-600"
  },
  {
    label: "Accessibility", 
    value: "100",
    description: "WCAG 2.1 Compliance",
    bgClass: "bg-gradient-to-r from-blue-500 to-indigo-600"
  },
  {
    label: "SEO",
    value: "98+",
    description: "Search Engine Optimization",
    bgClass: "bg-gradient-to-r from-purple-500 to-pink-600"
  },
  {
    label: "Best Practices",
    value: "100",
    description: "Modern Web Standards",
    bgClass: "bg-gradient-to-r from-orange-500 to-red-600"
  }
]

const implementationFeatures: ImplementationFeature[] = [
  {
    title: "Component Architecture",
    description: "Modular, reusable components following Vue.js best practices with proper prop typing and emit events.",
    techUsed: ["Vue 3", "TypeScript", "Composition API"]
  },
  {
    title: "Responsive Design",
    description: "Mobile-first approach ensuring optimal experience across all devices and screen sizes.",
    techUsed: ["TailwindCSS", "CSS Grid", "Flexbox"]
  },
  {
    title: "Type Safety",
    description: "Full TypeScript integration providing compile-time error checking and enhanced developer experience.",
    techUsed: ["TypeScript", "Vue 3", "TSConfig"]
  },
  {
    title: "Performance Optimization",
    description: "Lazy loading, code splitting, and optimized assets for fast loading times and smooth interactions.",
    techUsed: ["Vite", "Vue Router", "Dynamic Imports"]
  },
  {
    title: "State Management",
    description: "Centralized state management for user preferences, theme switching, and application data.",
    techUsed: ["Pinia", "Composables", "LocalStorage"]
  },
  {
    title: "Modern Deployment",
    description: "Automated build process with environment-specific configurations and optimized production builds.",
    techUsed: ["Vite", "GitHub Actions", "Static Hosting"]
  }
]
</script>

<style scoped>
.glass-card {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 16px;
}
</style>