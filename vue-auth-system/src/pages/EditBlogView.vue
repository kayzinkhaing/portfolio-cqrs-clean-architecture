<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-2xl bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-center text-indigo-600 mb-4">Edit Blog</h2>

      <!-- Show spinner while updating -->
      <LoadingSpinner v-if="isLoading" />

      <!-- Form -->
      <DynamicForm
        v-else
        :fields="fields"
        :form="form"
        :errors="errorStore.errors"
        :loading="isLoading"
        submit-label="Update Blog"
        @submit="handleUpdate"
      />

      <p v-if="errorStore.generalMessage" class="text-red-600 mt-2 text-center">
        {{ errorStore.generalMessage }}
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import LoadingSpinner from '../components/LoadingSpinner.vue'
import DynamicForm from '@/components/forms/DynamicForm.vue'
import useBlogs from '../composables/useBlogs'
import { useErrorStore } from '../stores/errorStore'
import { blogFields } from '../config/forms/blogFields'
import { validateBlogForm } from '../utils/blogValidation'
import type { BlogData } from '../api/types'

const route = useRoute()
const router = useRouter()
const errorStore = useErrorStore()
const { blogs, updateBlogMutation } = useBlogs()

const form = ref<BlogData>({
  title: '',
  excerpt: '',
  content: '',
  published_at: ''
})

const fields = ref(blogFields())
const isLoading = ref(false)

// Fetch blog data from Vue Query cache
onMounted(() => {
  const id = Number(route.params.id)
  const blog = blogs.value.find(b => b.id === id)
  if (!blog) return errorStore.setGeneralError('Blog not found.')

  form.value = {
    title: blog.title,
    excerpt: blog.excerpt || '',
    content: blog.content,
    published_at: blog.published_at?.slice(0, 16) || ''
  }
})

// Update blog
const handleUpdate = async () => {
  errorStore.clearErrors()
  const validationErrors = validateBlogForm(form.value)
  if (Object.keys(validationErrors).length > 0) {
    const errorsForStore: Record<string, string[]> = {}
    for (const key in validationErrors) errorsForStore[key] = [validationErrors[key]]
    errorStore.setValidationErrors(errorsForStore)
    return
  }

  const id = Number(route.params.id)
  if (!id) return errorStore.setGeneralError('Invalid blog ID.')

  isLoading.value = true
  updateBlogMutation.mutate(
    { id, data: form.value },
    {
      onSuccess: () => {
        isLoading.value = false
        router.push('/blogs')
      },
      onError: () => {
        isLoading.value = false
      }
    }
  )
}
</script>
