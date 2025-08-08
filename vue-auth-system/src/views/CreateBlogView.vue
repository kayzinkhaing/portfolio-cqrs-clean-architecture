<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="w-full max-w-2xl bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-center text-indigo-600 mb-4">Create Blog</h2>
    
            <LoadingSpinner v-if="isLoading" />
    
            <form v-else @submit.prevent="handleCreate" class="space-y-4">
                <!-- Title -->
                <BaseInput v-model="form.title" type="text" label="Title" placeholder="Enter blog title" required />
    
                <!-- Excerpt -->
                <BaseInput v-model="form.excerpt" type="text" label="Excerpt" placeholder="Optional short description" />
    
                <!-- Content -->
                <BaseTextarea v-model="form.content" label="Content" placeholder="Write your blog content here..." :rows="6"
                    required />
    
    
                <!-- Published At -->
                <BaseInput v-model="form.published_at" type="datetime-local" label="Publish Date" />
    
                <SubmitButton :loading="isLoading" label="Create Blog" />
            </form>
    
            <p v-if="errorMessage" class="text-red-600 mt-2 text-center">{{ errorMessage }}</p>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { createBlog } from '@/services/api' // ✅ make sure this API exists
import LoadingSpinner from '@/components/LoadingSpinner.vue'
import BaseInput from '@/components/BaseInput.vue'
import BaseTextarea from '@/components/BaseTextarea.vue'
import SubmitButton from '@/components/SubmitButton.vue'

const router = useRouter()

const isLoading = ref(false)
const errorMessage = ref('')

const form = ref({
  title: '',
  excerpt: '',
  content: '',
  published_at: '',
})

const handleCreate = async () => {
  errorMessage.value = ''
  isLoading.value = true
  try {
    await createBlog(form.value) // POST request to backend
    router.push('/blogs') // Redirect to blog list after success
  } catch (err) {
    errorMessage.value = err.response?.data?.message || 'Failed to create blog.'
    console.error(err)
  } finally {
    isLoading.value = false
  }
}
</script>
