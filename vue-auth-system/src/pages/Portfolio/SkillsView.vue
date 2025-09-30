<!-- src/pages/Portfolio/SkillsView.vue -->
<template>
  <div class="py-20 px-6 min-h-screen bg-gradient-to-br from-gray-900 via-blue-900/20 to-gray-900">
    <div class="max-w-7xl mx-auto">
      <SectionTitle 
        title="Skills & Abilities" 
        subtitle="My technical expertise across different domains"
        class="mb-16"
      />

      <!-- Skills Navigation -->
      <div class="flex flex-wrap justify-center gap-4 mb-12">
        <button
          v-for="category in skillCategories"
          :key="category.id"
          @click="activeCategory = category.id"
          :class="[
            'px-6 py-3 rounded-full font-medium transition-all duration-300',
            activeCategory === category.id 
              ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg' 
              : 'bg-gray-800/50 text-gray-300 hover:bg-gray-700/50 hover:text-white'
          ]"
        >
          <span class="mr-2">{{ category.icon }}</span>
          {{ category.title }}
        </button>
      </div>

      <!-- Active Category Display -->
      <div class="glass-card p-8 mb-12">
        <div class="text-center mb-8">
          <div :class="currentCategory.gradientClass" class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="text-3xl">{{ currentCategory.icon }}</span>
          </div>
          <h2 class="text-3xl font-bold text-white mb-2">{{ currentCategory.title }}</h2>
          <p class="text-gray-300 max-w-2xl mx-auto">{{ currentCategory.description }}</p>
        </div>

        <!-- Skills Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
          <SkillCard
            v-for="skill in currentCategory.skills"
            :key="skill.name"
            :name="skill.name"
            :level="skill.level"
            :icon="skill.icon"
            :color="skill.color"
            :experience="skill.experience"
            :projects="skill.projects"
          />
        </div>
      </div>

      <!-- Advanced Concepts Section -->
      <div v-if="currentCategory.advancedConcepts" class="glass-card p-8">
        <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
          <span class="bg-gradient-to-r from-pink-500 to-rose-500 w-8 h-8 rounded mr-3 flex items-center justify-center">
            🚀
          </span>
          Advanced Concepts & Best Practices
        </h3>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          <ConceptCard
            v-for="concept in currentCategory.advancedConcepts"
            :key="concept.title"
            :title="concept.title"
            :description="concept.description"
            :examples="concept.examples"
            :useCase="concept.useCase"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import SectionTitle from "@/components/portfolio/SectionTitle.vue"
import SkillCard from "@/components/portfolio/SkillCard.vue"
import ConceptCard from "@/components/portfolio/ConceptCard.vue"

interface Skill {
  name: string
  level: number
  icon: string
  color: string
  experience: string
  projects?: number
}

interface AdvancedConcept {
  title: string
  description: string
  examples: string[]
  useCase: string
}

interface SkillCategory {
  id: string
  title: string
  icon: string
  gradientClass: string
  description: string
  skills: Skill[]
  advancedConcepts?: AdvancedConcept[]
}

const activeCategory = ref('frontend')

const skillCategories: SkillCategory[] = [
  {
    id: 'frontend',
    title: 'Frontend Development',
    icon: '💻',
    gradientClass: 'bg-gradient-to-r from-blue-500 to-cyan-500',
    description: 'Building responsive, interactive user interfaces with modern frameworks and best practices',
    skills: [
      { name: 'HTML5', level: 95, icon: '🟧', color: 'orange', experience: '3+ years' },
      { name: 'CSS3', level: 90, icon: '🔵', color: 'blue', experience: '3+ years' },
      { name: 'JavaScript', level: 85, icon: '🟨', color: 'yellow', experience: '2+ years' },
      { name: 'TypeScript', level: 80, icon: '🔷', color: 'blue', experience: '1+ years' },
      { name: 'Vue.js', level: 90, icon: '🟢', color: 'green', experience: '2+ years' },
      { name: 'React.js', level: 70, icon: '⚛️', color: 'blue', experience: '6+ months' },
      { name: 'TailwindCSS', level: 90, icon: '🎨', color: 'cyan', experience: '1+ years' },
      { name: 'Bootstrap', level: 85, icon: '🅱️', color: 'purple', experience: '2+ years' }
    ],
    advancedConcepts: [
      {
        title: 'Vue Router (Advanced Navigation)',
        description: 'Complex routing patterns with guards and dynamic routes',
        examples: ['Nested routes', 'Route guards', 'Code splitting', 'Scroll behavior'],
        useCase: 'When building SPAs with authentication and protected routes'
      },
      {
        title: 'TypeScript with Vue',
        description: 'Type-safe Vue development with advanced TypeScript features',
        examples: ['Generic components', 'Typed props/emits', 'Store typing', 'Strict type checking'],
        useCase: 'Large applications requiring maintainability and error prevention'
      },
      {
        title: 'Component Composition',
        description: 'Advanced component patterns and reusability strategies',
        examples: ['Composables', 'Provide/Inject', 'Slots', 'Dynamic components'],
        useCase: 'Building scalable, maintainable component libraries'
      }
    ]
  },
  {
    id: 'backend',
    title: 'Backend Development',
    icon: '⚙️',
    gradientClass: 'bg-gradient-to-r from-green-500 to-emerald-500',
    description: 'Server-side development, APIs, and database management with robust architecture',
    skills: [
      { name: 'PHP', level: 90, icon: '🐘', color: 'indigo', experience: '3+ years' },
      { name: 'Laravel', level: 95, icon: '🔴', color: 'red', experience: '2+ years' },
      { name: 'RESTful APIs', level: 90, icon: '🔗', color: 'blue', experience: '2+ years' },
      { name: 'GraphQL', level: 60, icon: '🟣', color: 'pink', experience: '6+ months' },
      { name: 'Livewire', level: 80, icon: '⚡', color: 'pink', experience: '1+ years' },
      { name: 'Microservices', level: 65, icon: '🔧', color: 'purple', experience: '6+ months' }
    ],
    advancedConcepts: [
      {
        title: 'API Design Patterns',
        description: 'RESTful principles, GraphQL schemas, and API versioning strategies',
        examples: ['Resource-based URLs', 'HTTP status codes', 'Rate limiting', 'API documentation'],
        useCase: 'Building scalable, maintainable APIs for mobile and web applications'
      },
      {
        title: 'Database Optimization',
        description: 'Query optimization, indexing strategies, and database design patterns',
        examples: ['Query optimization', 'Database indexing', 'Relationship design', 'Migration strategies'],
        useCase: 'High-performance applications with complex data relationships'
      },
      {
        title: 'Authentication & Security',
        description: 'JWT tokens, OAuth, session management, and security best practices',
        examples: ['JWT implementation', 'OAuth flows', 'CSRF protection', 'Input validation'],
        useCase: 'Secure applications with user authentication and authorization'
      }
    ]
  },
  {
    id: 'database',
    title: 'Database & Data',
    icon: '🗄️',
    gradientClass: 'bg-gradient-to-r from-purple-500 to-pink-500',
    description: 'Database design, optimization, and data management across different systems',
    skills: [
      { name: 'MySQL', level: 85, icon: '🐬', color: 'orange', experience: '3+ years' },
      { name: 'PostgreSQL', level: 75, icon: '🐘', color: 'blue', experience: '1+ years' },
      { name: 'MongoDB', level: 70, icon: '🍃', color: 'green', experience: '1+ years' },
      { name: 'Redis', level: 80, icon: '🔴', color: 'red', experience: '1+ years' },
      { name: 'Firebase', level: 75, icon: '🔥', color: 'yellow', experience: '1+ years' },
      { name: 'SQL', level: 90, icon: '📊', color: 'blue', experience: '3+ years' },
      { name: 'Database Design', level: 85, icon: '🏗️', color: 'purple', experience: '2+ years' },
      { name: 'Data Modeling', level: 80, icon: '📐', color: 'cyan', experience: '2+ years' }
    ]
  },
  {
    id: 'algorithms',
    title: 'Data Structures & Algorithms',
    icon: '🧮',
    gradientClass: 'bg-gradient-to-r from-orange-500 to-red-500',
    description: 'Problem-solving with efficient algorithms and optimal data structure selection',
    skills: [
      { name: 'Arrays & Strings', level: 90, icon: '📝', color: 'blue', experience: '3+ years' },
      { name: 'Linked Lists', level: 85, icon: '🔗', color: 'green', experience: '2+ years' },
      { name: 'Trees & Graphs', level: 80, icon: '🌳', color: 'green', experience: '2+ years' },
      { name: 'Hash Tables', level: 85, icon: '#️⃣', color: 'purple', experience: '2+ years' },
      { name: 'Sorting Algorithms', level: 90, icon: '↕️', color: 'orange', experience: '3+ years' },
      { name: 'Dynamic Programming', level: 75, icon: '🔄', color: 'cyan', experience: '1+ years' },
      { name: 'Big O Analysis', level: 85, icon: '📈', color: 'red', experience: '2+ years' },
      { name: 'Problem Solving', level: 90, icon: '🧩', color: 'pink', experience: '3+ years' }
    ]
  },
  {
    id: 'devops',
    title: 'DevOps & Deployment',
    icon: '🚀',
    gradientClass: 'bg-gradient-to-r from-indigo-500 to-blue-500',
    description: 'Infrastructure management, CI/CD pipelines, and deployment automation',
    skills: [
      { name: 'Git', level: 90, icon: '📚', color: 'orange', experience: '3+ years' },
      { name: 'GitHub Actions', level: 80, icon: '⚡', color: 'gray', experience: '1+ years' },
      { name: 'Docker', level: 75, icon: '🐳', color: 'blue', experience: '1+ years' },
      { name: 'CI/CD', level: 80, icon: '🔄', color: 'green', experience: '1+ years' },
      { name: 'DigitalOcean', level: 75, icon: '🌊', color: 'blue', experience: '1+ years' },
      { name: 'Nginx', level: 70, icon: '🟢', color: 'green', experience: '1+ years' },
      { name: 'Linux', level: 75, icon: '🐧', color: 'gray', experience: '1+ years' }
    ]
  },
  {
    id: 'tools',
    title: 'Development Tools',
    icon: '🛠️',
    gradientClass: 'bg-gradient-to-r from-yellow-500 to-orange-500',
    description: 'Essential tools and utilities that enhance development productivity',
    skills: [
      { name: 'VS Code', level: 95, icon: '💙', color: 'blue', experience: '3+ years' },
      { name: 'Postman', level: 85, icon: '📮', color: 'orange', experience: '2+ years' },
      { name: 'Figma', level: 70, icon: '🎨', color: 'purple', experience: '1+ years' },
      { name: 'Chrome DevTools', level: 90, icon: '🔍', color: 'blue', experience: '3+ years'},
      { name: 'Terminal/CLI', level: 85, icon: '⌨️', color: 'gray', experience: '2+ years' },
      { name: 'NPM/Yarn', level: 85, icon: '📦', color: 'red', experience: '2+ years' },
      { name: 'Webpack/Vite', level: 80, icon: '⚡', color: 'purple', experience: '1+ years' },
      { name: 'ESLint/Prettier', level: 85, icon: '✨', color: 'green', experience: '2+ years' }
    ]
  }
]

const currentCategory = computed(() => 
  skillCategories.find(cat => cat.id === activeCategory.value) || skillCategories[0]
)
</script>

<style scoped>
.glass-card {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 20px;
}
</style>