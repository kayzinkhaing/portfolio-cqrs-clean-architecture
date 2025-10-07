<!-- src/pages/Portfolio/SiteTechnologiesView.vue -->
<template>
  <div class="py-20 px-6">
    <div class="max-w-6xl mx-auto">
      <!-- Section Title -->
      <SectionTitle 
        title="Site Technologies" 
        subtitle="Complete technology ecosystem powering this portfolio — from frontend to backend and deployment infrastructure."
        class="mb-16"
      />

      <!-- System Overview -->
      <div class="glass-card p-8 mb-12">
        <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
          <span class="bg-gradient-to-r from-indigo-500 to-purple-500 w-8 h-8 rounded mr-3 flex items-center justify-center">
            🧩
          </span>
          System Overview
        </h3>
        <p class="text-gray-300 leading-relaxed">
          This portfolio demonstrates a production-grade architecture using a <strong>CQRS-driven</strong> backend with 
          <strong>Laravel + GraphQL (Lighthouse)</strong> and <strong>MongoDB</strong> for scalable data operations.  
          The frontend is a <strong>Vue 3 + TypeScript</strong> single-page application communicating via 
          <strong>Apollo GraphQL client</strong>. CI/CD pipelines automate Docker-based builds, testing, and deployment 
          to a secure cloud environment.
        </p>
      </div>

      <!-- Frontend Stack -->
      <div class="glass-card p-8 mb-12">
        <h3 class="text-2xl font-bold text-white mb-8 flex items-center">
          <span class="bg-gradient-to-r from-green-500 to-emerald-500 w-8 h-8 rounded mr-3 flex items-center justify-center">🎨</span>
          Frontend Stack
        </h3>

        <div class="grid md:grid-cols-2 gap-8">
          <TechnologyCard 
            name="Vue.js 3 + TypeScript"
            version="3.5.x / 5.x"
            purpose="Modern reactive frontend framework with static typing"
            :features="[
              'Composition API & Composables',
              'Pinia for state management',
              'Vue Router for SPA navigation',
              'Reusable component-driven UI'
            ]"
            color="green"
          />
          <TechnologyCard 
            name="GraphQL + Apollo Client"
            version="16.x / 3.x"
            purpose="Efficient data fetching and schema-based client-server contract"
            :features="[
              'Typed operations with Codegen',
              'Optimistic UI updates',
              'Caching and reactivity',
              'Error handling with Vue Query'
            ]"
            color="blue"
          />
          <TechnologyCard 
            name="TailwindCSS + Custom Design System"
            version="3.x"
            purpose="Responsive and consistent UI styling"
            :features="[
              'Custom glassmorphism utilities',
              'Dark mode integration',
              'Adaptive layouts',
              'Performance-optimized CSS build'
            ]"
            color="cyan"
          />
          <TechnologyCard 
            name="Vite Build Tool"
            version="7.x"
            purpose="Blazing fast development and optimized production builds"
            :features="[
              'HMR (Hot Module Replacement)',
              'Type checking with TSConfig',
              'Linting & testing with Vitest',
              'GraphQL code generation pipeline'
            ]"
            color="purple"
          />
        </div>
      </div>

      <!-- Backend Stack -->
      <div class="glass-card p-8 mb-12">
        <h3 class="text-2xl font-bold text-white mb-8 flex items-center">
          <span class="bg-gradient-to-r from-orange-500 to-red-500 w-8 h-8 rounded mr-3 flex items-center justify-center">⚙️</span>
          Backend Stack
        </h3>

        <div class="grid md:grid-cols-2 gap-8">
          <TechnologyCard 
            name="Laravel 12 (PHP 8.2)"
            version="12.x"
            purpose="Core application backend implementing CQRS pattern"
            :features="[
              'Command & Query segregation (CQRS)',
              'Sanctum for API authentication',
              'GraphQL API with Lighthouse',
              'Event-driven jobs via RabbitMQ'
            ]"
            color="red"
          />
          <TechnologyCard 
            name="MongoDB + MySQL"
            version="6.x / 8.x"
            purpose="Hybrid storage solution for structured & document-based data"
            :features="[
              'MongoDB for flexible domain models',
              'MySQL for transactional data',
              'Eloquent ORM integration',
              'Laravel MongoDB driver support'
            ]"
            color="green"
          />
          <TechnologyCard 
            name="Redis + Pusher + RabbitMQ"
            version="7.x"
            purpose="Real-time messaging and async processing infrastructure"
            :features="[
              'Redis caching & queues',
              'RabbitMQ job distribution',
              'Pusher event broadcasting',
              'Optimized API response latency'
            ]"
            color="orange"
          />
          <TechnologyCard 
            name="Lighthouse GraphQL"
            version="6.x"
            purpose="Schema-first GraphQL implementation for Laravel"
            :features="[
              'Schema-based validation',
              'Field-level resolvers',
              'Auth directives & guards',
              'Pagination & relationships via schema'
            ]"
            color="blue"
          />
        </div>
      </div>

      <!-- Infrastructure & DevOps -->
      <div class="glass-card p-8 mb-12">
        <h3 class="text-2xl font-bold text-white mb-8 flex items-center">
          <span class="bg-gradient-to-r from-sky-500 to-blue-600 w-8 h-8 rounded mr-3 flex items-center justify-center">☁️</span>
          Infrastructure & DevOps
        </h3>

        <div class="grid md:grid-cols-2 gap-8">
          <TechnologyCard 
            name="Docker + Docker Compose"
            version="24.x"
            purpose="Containerized local and production environments"
            :features="[
              'Multi-service stack (Nginx, PHP, MySQL, Redis, Vue)',
              'Environment parity between local & production',
              'Versioned images via Docker Hub',
              'Custom network & volume configuration'
            ]"
            color="sky"
          />
          <TechnologyCard 
            name="GitHub Actions + CI/CD"
            version="latest"
            purpose="Automated testing, build, and deployment pipelines"
            :features="[
              'Linting, unit tests, and coverage reports',
              'Docker build & push automation',
              'SSH deploy to DigitalOcean droplet',
              'Secrets-managed environment variables'
            ]"
            color="indigo"
          />
        </div>
      </div>

      <!-- Performance Metrics -->
      <div class="glass-card p-8 mb-12">
        <h3 class="text-2xl font-bold text-white mb-8 text-center">Performance & Quality</h3>
        <div class="grid md:grid-cols-4 gap-6">
          <div v-for="metric in performanceMetrics" :key="metric.label" class="text-center group">
            <div :class="metric.bgClass" class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
              <span class="text-2xl font-bold text-white">{{ metric.value }}</span>
            </div>
            <h4 class="text-white font-semibold mb-2">{{ metric.label }}</h4>
            <p class="text-gray-400 text-sm">{{ metric.description }}</p>
          </div>
        </div>
      </div>

      <!-- Key Capabilities -->
      <div class="glass-card p-8">
        <h3 class="text-2xl font-bold text-white mb-8 flex items-center">
          <span class="bg-gradient-to-r from-pink-500 to-rose-500 w-8 h-8 rounded mr-3 flex items-center justify-center">💡</span>
          Key Capabilities
        </h3>
        <ul class="space-y-4 text-gray-300 list-disc pl-6">
          <li>Clean CQRS pattern ensuring scalability and maintainable backend logic.</li>
          <li>End-to-end type safety across GraphQL schema, client, and server.</li>
          <li>Containerized workflow with consistent local and production setups.</li>
          <li>High Lighthouse scores for performance, accessibility, and SEO.</li>
          <li>Continuous delivery via GitHub Actions and Docker Hub integration.</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import SectionTitle from "@/components/portfolio/SectionTitle.vue"
import TechnologyCard from "@/components/portfolio/TechnologyCard.vue"

const performanceMetrics = [
  {
    label: "Performance",
    value: "95+",
    description: "Optimized asset loading and lazy hydration",
    bgClass: "bg-gradient-to-r from-green-500 to-emerald-600"
  },
  {
    label: "Accessibility",
    value: "100",
    description: "WCAG 2.1 compliance and keyboard navigation",
    bgClass: "bg-gradient-to-r from-blue-500 to-indigo-600"
  },
  {
    label: "SEO",
    value: "98+",
    description: "Optimized metadata and structured content",
    bgClass: "bg-gradient-to-r from-purple-500 to-pink-600"
  },
  {
    label: "Best Practices",
    value: "100",
    description: "Modern architecture and coding standards",
    bgClass: "bg-gradient-to-r from-orange-500 to-red-600"
  }
]
</script>

<style scoped>
.glass-card {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 18px;
  transition: all 0.3s ease;
}
.glass-card:hover {
  border-color: rgba(255, 255, 255, 0.2);
  transform: translateY(-2px);
}
</style>
