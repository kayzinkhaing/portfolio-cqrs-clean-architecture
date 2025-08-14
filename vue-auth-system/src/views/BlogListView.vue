<template>
  <div class="max-w-5xl mx-auto py-10 px-4">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
      <h1 class="text-3xl font-bold text-indigo-800">All Blogs</h1>
  
      <!-- Add Blog -->
      <router-link v-if="canAddBlog" to="/create-blog"
        class="mt-4 md:mt-0 inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-700 text-white font-medium rounded-lg shadow hover:from-indigo-600 hover:to-indigo-800 transition duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add Blog
      </router-link>
    </div>
  
    <!-- Error -->
    <div v-if="status === 'error'"
      class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6 text-center">
      {{ error?.message || errorStore.generalMessage || 'Error loading blogs.' }}
    </div>
  
    <!-- Empty -->
    <div v-else-if="status === 'success' && blogs.length === 0" class="text-gray-500 text-center italic">
      No blogs available.
    </div>
  
    <!-- Blog List -->
    <div v-else-if="status === 'success'" class="grid md:grid-cols-2 gap-6">
      <BlogCard v-for="blog in blogs" :key="blog.id" :blog="blog" :is-owner="isBlogOwner(blog)"
        :deleting="deletingBlogId === blog.id" @delete="handleDelete(blog.id)" />
    </div>
  
    <!-- Load More -->
    <div v-if="canLoadMore" class="mt-8 text-center">
      <button
        class="px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
        :disabled="isFetchingNextPage" @click="loadMore">
        {{ isFetchingNextPage ? 'Loading more...' : 'Load More' }}
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import useBlogs from '../composables/useBlogs'
import BlogCard from '@/components/BlogCard.vue'

const {
  blogs,
  status,
  error,
  errorStore,
  auth,
  currentUserId,
  handleDelete,
  deletingBlogId,
  hasNextPage,
  isFetchingNextPage,
  loadMore
} = useBlogs()

// --- Computed Helpers ---
const canAddBlog = computed(() => status.value === 'success' && auth.isAuthenticated)
const canLoadMore = computed(() => hasNextPage.value && status.value === 'success')

const isBlogOwner = (blog: any) => auth.isAuthenticated && blog.user?.id === currentUserId.value
</script>
