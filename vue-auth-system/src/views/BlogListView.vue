<script setup>
import { ref, onMounted } from 'vue'
import { getBlogs, deleteBlog } from '@/services/api'
import { useAuthStore } from '@/stores/auth'
import LoadingSpinner from '@/components/LoadingSpinner.vue'
import DangerButton from '@/components/DangerButton.vue'

const blogs = ref([])
const loading = ref(false)
const error = ref(null)
const deletingId = ref(null)

const auth = useAuthStore()

const fetchBlogs = async () => {
  loading.value = true
  error.value = null
  try {
    const response = await getBlogs()
    blogs.value = response.data
  } catch (err) {
    error.value = 'Failed to load blogs.'
    console.error(err)
  } finally {
    loading.value = false
  }
}

const handleDelete = async (id) => {
  if (!confirm('Are you sure you want to delete this blog?')) return

  deletingId.value = id
  try {
    await deleteBlog(id)
    blogs.value = blogs.value.filter(blog => blog.id !== id)
  } catch (err) {
    alert('Failed to delete blog.')
    console.error(err)
  } finally {
    deletingId.value = null
  }
}

onMounted(fetchBlogs)
</script>

<template>
  <div class="max-w-4xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-6 text-center text-indigo-800">All Blogs</h1>

    <LoadingSpinner v-if="loading" />

    <div v-if="error" class="text-red-500 text-center mb-4">{{ error }}</div>

    <div v-if="!loading && blogs.length === 0" class="text-gray-500 text-center">
      No blogs available.
    </div>

    <div v-if="!loading && auth.isAuthenticated" class="mb-6 text-right">
      <router-link to="/create-blog" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
        Add Blog
      </router-link>
    </div>

    <div v-if="!loading && blogs.length > 0" class="space-y-6">
      <div
        v-for="blog in blogs"
        :key="blog.id"
        class="border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition duration-300"
      >
        <div class="flex justify-between items-start">
          <div>
            <h2 class="text-xl font-semibold mb-1 text-indigo-700">{{ blog.title }}</h2>
            <p class="text-sm text-gray-500 mb-2">By {{ blog.user?.name ?? 'Unknown' }}</p>
          </div>
          <div class="flex items-center space-x-4">
            <router-link
              v-if="auth.isAuthenticated && blog.user && auth.user?.id === blog.user.id"
              :to="`/edit-blog/${blog.id}`"
              class="text-indigo-600 hover:text-indigo-800 transition"
            >
              Edit
            </router-link>

            <DangerButton
              v-if="auth.user && blog.user && auth.user.id === blog.user.id"
              :loading="deletingId === blog.id"
              @click="handleDelete(blog.id)"
            >
              Delete
            </DangerButton>
          </div>
        </div>

        <p class="text-gray-800">
          {{ blog.excerpt ?? (blog.content?.slice(0, 150) + '...') }}
        </p>
      </div>
    </div>
  </div>
</template>
