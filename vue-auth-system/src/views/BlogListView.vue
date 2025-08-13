<script setup lang="ts">
import { computed } from 'vue'
import useBlogs from '../composables/useBlogs'
import DangerButton from '@/components/DangerButton.vue'

const {
  blogs,
  status,
  error,
  deletingBlogId,
  currentUserId,
  auth,
  errorStore,
  deleteMutation,
  handleDelete,
  hasNextPage,
  isFetchingNextPage,
  onLoadMore,
} = useBlogs()
</script>

<template>
  <div class="max-w-4xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold mb-6 text-center text-indigo-800">All Blogs</h1>
  
    <!-- Loading state (uncomment if you add spinner component) -->
    <!-- <LoadingSpinner v-if="status === 'loading'" /> -->
  
    <!-- Error message -->
    <div v-if="status === 'error'" class="text-red-500 text-center mb-4">
      {{ error?.message || errorStore.generalMessage || 'Error loading blogs.' }}
    </div>
  
    <!-- No blogs message -->
    <div v-if="status === 'success' && blogs.length === 0" class="text-gray-500 text-center">
      No blogs available.
    </div>
  
    <!-- Add blog button (visible if logged in) -->
    <div v-if="status === 'success' && auth.isAuthenticated" class="mb-6 text-right">
      <router-link to="/create-blog" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
        Add Blog
      </router-link>
    </div>
  
    <!-- Blog list -->
    <div v-if="status === 'success' && blogs.length > 0" class="space-y-6">
      <div v-for="blog in blogs" :key="blog.id"
        class="border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition duration-300">
        <div class="flex justify-between items-start">
          <div>
            <h2 class="text-xl font-semibold mb-1 text-indigo-700">{{ blog.title }}</h2>
            <p class="text-sm text-gray-500 mb-2">By {{ blog.user?.name ?? 'Unknown' }}</p>
          </div>
  
          <div class="flex items-center space-x-4">
            <router-link v-if="auth.isAuthenticated && blog.user && currentUserId === blog.user.id"
              :to="`/edit-blog/${blog.id}`" class="text-indigo-600 hover:text-indigo-800 transition">
              Edit
            </router-link>
  
            <DangerButton v-if="auth.isAuthenticated && blog.user && currentUserId === blog.user.id"
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
  
    <!-- Load more button -->
    <div v-if="hasNextPage && status === 'success'" class="mt-6 text-center">
      <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition"
        :disabled="isFetchingNextPage" @click="onLoadMore">
        {{ isFetchingNextPage ? 'Loading more...' : 'Load more' }}
      </button>
    </div>
  </div>
</template>
