<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-2xl bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-center text-indigo-600 mb-4">Create Blog</h2>
  
      <LoadingSpinner v-if="isLoading" />
  
      <DynamicForm v-else :fields="fields" :form="form" :errors="errorStore.errors" :loading="isLoading"
        submit-label="Create Blog" @submit="handleCreate" />
  
      <p v-if="errorStore.generalMessage" class="text-red-600 mt-4 text-center">
        {{ errorStore.generalMessage }}
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { createBlog } from '../services/blog'
import LoadingSpinner from '../components/LoadingSpinner.vue'
import DynamicForm from '@/components/forms/DynamicForm.vue'
import { validateBlogForm } from '../utils/blogValidation'
import { blogFields } from '../config/forms/blogFields'
import { useErrorStore } from '../stores/errorStore'
import { handleApiError } from '../utils/errorHandler'
export interface BlogForm {
  title: string
  excerpt: string
  content: string
  published_at?: string
}

const router = useRouter()
const errorStore = useErrorStore()

const isLoading = ref(false)

const form = ref<BlogForm>({
  title: '',
  excerpt: '',
  content: '',
  published_at: '',
})

const fields = computed(() => blogFields())

const handleCreate = async () => {
  errorStore.clearErrors()

  const validationErrors = validateBlogForm(form.value); // Record<string, string>

  const errorsForStore: Record<string, string[]> = {};
  for (const key in validationErrors) {
    errorsForStore[key] = [validationErrors[key]];
  }

  errorStore.setValidationErrors(errorsForStore);


  isLoading.value = true
  try {
    await createBlog(form.value)
    router.push('/blogs')
  } catch (error) {
    handleApiError(error)  // This updates errorStore automatically
  } finally {
    isLoading.value = false
  }
}
</script>
