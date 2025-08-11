<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { getBlogs, deleteBlog } from '../services/api'
import { useAuthStore } from '../stores/auth'
import { useErrorStore } from '../stores/errorStore'
import { handleApiError } from '../utils/errorHandler'
import LoadingSpinner from '../components/LoadingSpinner.vue'
import DangerButton from '@/components/DangerButton.vue'
import Pagination from '@/components/Pagination.vue'
import type { Ref } from 'vue'

interface User {
  id: number | string
  name: string
}

interface Blog {
  id: number | string
  title: string
  excerpt?: string | null
  content: string
  user?: User | null
}

const blogs: Ref<Blog[]> = ref([])
const isLoading = ref(false)
const deletingBlogId = ref<number | string | null>(null)

const currentPage = ref(1)
const lastPage = ref(1)

const auth = useAuthStore()
const errorStore = useErrorStore()

const fetchBlogs = async (page = 1) => {
  isLoading.value = true
  errorStore.clearErrors()
  try {
    const response = await getBlogs(page)
    blogs.value = response.data.data
    currentPage.value = response.data.current_page
    lastPage.value = response.data.last_page
  } catch (error) {
    handleApiError(error)
  } finally {
    isLoading.value = false
  }
}

const handlePageChange = (page: number) => {
  if (page !== currentPage.value) {
    fetchBlogs(page)
  }
}

const handleDelete = async (id: number | string) => {
  if (!confirm('Are you sure you want to delete this blog?')) return
  deletingBlogId.value = id
  errorStore.clearErrors()
  try {
    await deleteBlog(id)
    blogs.value = blogs.value.filter(blog => blog.id !== id)
  } catch (error) {
    handleApiError(error)
  } finally {
    deletingBlogId.value = null
  }
}

onMounted(() => fetchBlogs())
</script>

<template>
  <div class="max-w-4xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-6 text-center text-indigo-800">All Blogs</h1>

    <LoadingSpinner v-if="isLoading" />

    <div v-if="errorStore.generalMessage" class="text-red-500 text-center mb-4">
      {{ errorStore.generalMessage }}
    </div>

    <div v-if="!isLoading && blogs.length === 0" class="text-gray-500 text-center">
      No blogs available.
    </div>

    <div v-if="!isLoading && auth.isAuthenticated" class="mb-6 text-right">
      <router-link to="/create-blog" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
        Add Blog
      </router-link>
    </div>

    <div v-if="!isLoading && blogs.length > 0" class="space-y-6">
      <div v-for="blog in blogs" :key="blog.id"
        class="border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition duration-300">
        <div class="flex justify-between items-start">
          <div>
            <h2 class="text-xl font-semibold mb-1 text-indigo-700">{{ blog.title }}</h2>
            <p class="text-sm text-gray-500 mb-2">By {{ blog.user?.name ?? 'Unknown' }}</p>
          </div>
          <div class="flex items-center space-x-4">
            <router-link v-if="auth.isAuthenticated && blog.user && auth.user?.id === blog.user.id"
              :to="`/edit-blog/${blog.id}`" class="text-indigo-600 hover:text-indigo-800 transition">
              Edit
            </router-link>

            <DangerButton v-if="auth.user && blog.user && auth.user.id === blog.user.id"
              :loading="deletingBlogId === blog.id" @click="handleDelete(blog.id)">
              Delete
            </DangerButton>
          </div>
        </div>

        <p class="text-gray-800">
          {{ blog.excerpt ?? (blog.content.slice(0, 150) + '...') }}
        </p>
      </div>
    </div>

    <Pagination
      v-if="!isLoading && blogs.length > 0"
      :current-page="currentPage"
      :last-page="lastPage"
      @page-change="handlePageChange"
    />
  </div>
</template>
