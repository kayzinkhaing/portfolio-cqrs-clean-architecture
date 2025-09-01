<!-- src/components/portfolio/ConceptCard.vue -->
<template>
  <div class="concept-card bg-gray-800/30 rounded-lg p-6 border border-gray-700/50 hover:border-indigo-500/50 transition-all duration-300 group">
    <h4 class="text-lg font-bold text-white mb-3 group-hover:text-indigo-400 transition-colors">
      {{ title }}
    </h4>
    
    <p class="text-gray-300 text-sm mb-4 leading-relaxed">
      {{ description }}
    </p>

    <!-- Examples -->
    <div class="mb-4">
      <h5 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Examples</h5>
      <div class="flex flex-wrap gap-2">
        <span 
          v-for="example in examples"
          :key="example"
          class="px-2 py-1 bg-indigo-900/30 text-indigo-300 text-xs rounded border border-indigo-700/30"
        >
          {{ example }}
        </span>
      </div>
    </div>

    <!-- Use Case -->
    <div class="border-t border-gray-700/50 pt-3">
      <h5 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">When to Use</h5>
      <p class="text-gray-400 text-xs leading-relaxed">
        {{ useCase }}
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Props {
  title: string
  description: string
  examples: string[]
  useCase: string
}

defineProps<Props>()
</script>