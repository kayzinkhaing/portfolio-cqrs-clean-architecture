<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { getBlog, updateBlog } from '@/services/api' // implement your API calls
import LoadingSpinner from '@/components/LoadingSpinner.vue'
import BaseInput from '@/components/BaseInput.vue'
import BaseTextarea from '@/components/BaseTextarea.vue'
import SubmitButton from '@/components/SubmitButton.vue'
import { useAuthStore } from '@/stores/auth'

const route = useRoute()
const router = useRouter()
const auth = useAuthStore()

const isLoading = ref(false)
const errorMessage = ref('')
const form = ref({
  title: '',
  excerpt: '',
  content: '',
  published_at: '',
})

const fetchBlog = async () => {
  isLoading.value = true
  errorMessage.value = ''
  try {
    const res = await getBlog(route.params.id)
    const blog = res.data

    // Authorization check - only owner can edit
    if (auth.user?.id !== blog.user_id) {
      errorMessage.value = 'You are not authorized to edit this blog.'
      return
    }

    form.value.title = blog.title
    form.value.excerpt = blog.excerpt || ''
    form.value.content = blog.content
    form.value.published_at = blog.published_at ? blog.published_at.slice(0, 16) : ''
  } catch (err) {
    errorMessage.value = 'Failed to load blog data.'
    console.error(err)
  } finally {
    isLoading.value = false
  }
}

const handleUpdate = async () => {
  errorMessage.value = ''
  isLoading.value = true
  try {
    await updateBlog(route.params.id, form.value)
    router.push('/blogs')
  } catch (err) {
    errorMessage.value = err.response?.data?.message || 'Update failed.'
    console.error(err)
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  fetchBlog()
})
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-2xl bg-white shadow-md rounded-lg p-6">
      <h2 class="text-2xl font-bold text-center text-indigo-600 mb-4">Edit Blog</h2>
  
      <LoadingSpinner v-if="isLoading" />
  
      <form v-else @submit.prevent="handleUpdate" class="space-y-4">
        <BaseInput v-model="form.title" label="Title" placeholder="Enter blog title" required />
  
        <BaseTextarea v-model="form.excerpt" label="Excerpt (Optional)" placeholder="Short excerpt" />
  
        <BaseTextarea v-model="form.content" label="Content" placeholder="Write your blog content here..." rows="10"
          required />
  
        <label class="block text-gray-700 font-medium">
          Publish Date and Time
          <input v-model="form.published_at" type="datetime-local"
            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2" />
        </label>
  
        <SubmitButton :loading="isLoading" label="Update Blog" />
      </form>
  
      <p v-if="errorMessage" class="text-red-600 mt-2 text-center">{{ errorMessage }}</p>
    </div>
  </div>
</template>
