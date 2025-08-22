<template>
  <div class="bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition duration-300 p-6 flex flex-col justify-between">
    <!-- Header -->
    <div class="flex justify-between items-start mb-4">
      <div>
        <h2 class="text-xl font-semibold text-indigo-700 hover:underline">{{ blog.title }}</h2>
        <p class="text-sm text-gray-500">By {{ blog.user?.name ?? 'Unknown' }}</p>
      </div>

      <!-- Actions -->
      <div v-if="isOwner" class="flex space-x-3">
        <router-link :to="`/edit-blog/${blog.id}`">
          <BaseButton variant="secondary">
            <template #icon>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11 5h2M4 13v6a2 2 0 002 2h6a2 2 0 002-2v-6M18.364 5.636a2 2 0 010 2.828L12 14.828l-3 1 1-3 6.364-6.364a2 2 0 012.828 0z" />
              </svg>
            </template>
            Edit
          </BaseButton>
        </router-link>

        <DangerButton :loading="deleting" loading-text="Deleting..." @click="$emit('delete')">
          Delete
        </DangerButton>
      </div>
    </div>

    <!-- Excerpt -->
    <p class="text-gray-700 leading-relaxed">
      {{ blog.excerpt ?? blog.content.slice(0, 150) + '...' }}
    </p>
  </div>
</template>

<script setup lang="ts">
import BaseButton from '@/components/BaseButton.vue'
import DangerButton from '@/components/DangerButton.vue'

interface Props {
  blog: any
  isOwner: boolean
  deleting: boolean
}

defineProps<Props>()
defineEmits(['delete'])
</script>
