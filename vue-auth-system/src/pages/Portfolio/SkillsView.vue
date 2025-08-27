<template>
  <div class="py-20 px-6">
    <div class="max-w-6xl mx-auto">
      <SectionTitle 
        title="Technical Skills" 
        subtitle="Technologies and tools I work with"
        class="mb-16"
      />

      <!-- Skill Categories -->
      <div class="space-y-12">
        <div 
          v-for="category in skillCategories" 
          :key="category.title" 
          class="glass-card p-8"
        >
          <h3 class="text-2xl font-bold text-white mb-8 flex items-center">
            <span :class="category.iconClass" class="w-8 h-8 rounded mr-3"></span>
            {{ category.title }}
          </h3>
          <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <SkillBadge 
              v-for="skill in category.skills" 
              :key="skill.name" 
              :name="skill.name" 
              :level="skill.level" 
              :color="skill.color" 
            />
          </div>
        </div>
      </div>

      <!-- Skill Highlights -->
      <div class="mt-16">
        <h3 class="text-3xl font-bold text-white text-center mb-12">Core Competencies</h3>
        <div class="grid md:grid-cols-3 gap-8">
          <div 
            v-for="highlight in skillHighlights" 
            :key="highlight.title"
            class="glass-card p-6 text-center group hover:scale-105 transition-transform duration-300"
          >
            <div :class="highlight.iconClass" class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:animate-pulse">
              <span class="text-2xl">{{ highlight.icon }}</span>
            </div>
            <h4 class="text-xl font-bold text-white mb-3">{{ highlight.title }}</h4>
            <p class="text-white">{{ highlight.description }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import SectionTitle from "@/components/portfolio/SectionTitle.vue"
import SkillBadge from "@/components/portfolio/SkillBadge.vue"

interface Skill {
  name: string
  level: number
  color: string
}

interface SkillCategory {
  title: string
  iconClass: string
  skills: Skill[]
}

interface Highlight {
  title: string
  icon: string
  iconClass: string
  description: string
}

// Define all skill categories
const skillCategories: SkillCategory[] = [
  {
    title: "Frontend Development",
    iconClass: "bg-gradient-to-r from-blue-500 to-cyan-500",
    skills: [
      { name: "HTML5", level: 95, color: "orange" },
      { name: "CSS3", level: 90, color: "blue" },
      { name: "JavaScript", level: 85, color: "yellow" },
      { name: "Vue.js", level: 90, color: "green" },
      { name: "jQuery", level: 80, color: "blue" },
      { name: "Bootstrap", level: 85, color: "purple" },
      { name: "TailwindCSS", level: 90, color: "cyan" },
      { name: "Blade", level: 85, color: "red" },
    ],
  },
  {
    title: "Backend Development",
    iconClass: "bg-gradient-to-r from-green-500 to-emerald-500",
    skills: [
      { name: "PHP", level: 90, color: "indigo" },
      { name: "Laravel", level: 95, color: "red" },
      { name: "Livewire", level: 80, color: "pink" },
      { name: "OOP", level: 90, color: "blue" },
      { name: "SOLID Principles", level: 85, color: "purple" },
      { name: "RESTful APIs", level: 90, color: "green" },
      { name: "MySQL", level: 85, color: "orange" },
      { name: "Firebase", level: 75, color: "yellow" },
    ],
  },
  {
    title: "Tools & Deployment",
    iconClass: "bg-gradient-to-r from-purple-500 to-pink-500",
    skills: [
      { name: "Git", level: 90, color: "orange" },
      { name: "GitHub", level: 85, color: "gray" },
      { name: "Docker", level: 75, color: "blue" },
      { name: "CI/CD", level: 80, color: "green" },
      { name: "Postman", level: 85, color: "orange" },
      { name: "VS Code", level: 95, color: "blue" },
      { name: "Figma", level: 70, color: "purple" },
      { name: "DigitalOcean", level: 75, color: "blue" },
    ],
  },
]

// Core Competencies
const skillHighlights: Highlight[] = [
  { title: "Full-Stack Development", icon: "⚡", iconClass: "bg-gradient-to-r from-indigo-500 to-purple-600", description: "End-to-end web application development with modern frameworks" },
  { title: "API Development", icon: "🔧", iconClass: "bg-gradient-to-r from-green-500 to-emerald-600", description: "RESTful API design and integration with third-party services" },
  { title: "Performance Optimization", icon: "🚀", iconClass: "bg-gradient-to-r from-pink-500 to-rose-600", description: "Scalable applications with clean architecture and best practices" },
]
</script>
