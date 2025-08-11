<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-2xl bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-center text-indigo-600 mb-4">Edit Blog</h2>
  
      <LoadingSpinner v-if="isLoading" />
  
      <DynamicForm v-else :fields="fields" :form="form" :errors="errorStore.errors" :loading="isLoading"
        submit-label="Update Blog" @submit="handleUpdate" />
  
      <p v-if="errorStore.generalMessage" class="text-red-600 mt-2 text-center">
        {{ errorStore.generalMessage }}
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { getBlog, updateBlog } from '../services/api'
import LoadingSpinner from '../components/LoadingSpinner.vue'
import DynamicForm from '@/components/DynamicForm.vue'
import { useAuthStore } from '../stores/auth'
import { useErrorStore } from '../stores/errorStore'
import { validateBlogForm } from '../utils/blogValidation'
import { blogFields } from '../config/forms/blogFields'
import { handleApiError } from '../utils/errorHandler'

interface BlogForm {
  title: string
  excerpt: string
  content: string
  published_at: string
}

interface BlogData {
  id: number | string
  user_id: number | string
  title: string
  excerpt?: string
  content: string
  published_at?: string
}

const route = useRoute()
const router = useRouter()
const auth = useAuthStore()
const errorStore = useErrorStore()

const isLoading = ref(false)
const form = ref<BlogForm>({
  title: '',
  excerpt: '',
  content: '',
  published_at: '',
})

const fields = computed(() => blogFields())

const fetchBlog = async () => {
  isLoading.value = true
  errorStore.clearErrors()
  try {
    const res = await getBlog(route.params.id as string | number)
    const blog: BlogData = res.data

    if (auth.user?.id !== blog.user_id) {
      errorStore.setGeneralError('You are not authorized to edit this blog.')
      return
    }

    form.value = {
      title: blog.title,
      excerpt: blog.excerpt || '',
      content: blog.content,
      published_at: blog.published_at ? blog.published_at.slice(0, 16) : '',
    }
  } catch (error) {
    errorStore.setGeneralError('Failed to load blog data.')
    console.error(error)
  } finally {
    isLoading.value = false
  }
}

const handleUpdate = async () => {
  errorStore.clearErrors()

  const validationErrors = validateBlogForm(form.value) // Record<string, string>

  if (Object.keys(validationErrors).length > 0) {
    const errorsForStore: Record<string, string[]> = {}
    for (const key in validationErrors) {
      errorsForStore[key] = [validationErrors[key]]
    }
    errorStore.setValidationErrors(errorsForStore)
    return
  }

  isLoading.value = true
  try {
    await updateBlog(route.params.id as string | number, form.value)
    router.push('/blogs')
  } catch (error) {
    handleApiError(error)
  } finally {
    isLoading.value = false
  }
}

onMounted(fetchBlog)
</script>
