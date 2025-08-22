<template>
  <div class="p-8 bg-white rounded-3xl shadow-xl">
    <div class="flex items-center justify-between mb-8">
      <h2 class="text-3xl font-bold text-gray-800">Your Stories</h2>
      <router-link to="/create-blog" class="inline-flex items-center gap-2 bg-purple-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-purple-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        <span>New Story</span>
      </router-link>
    </div>

    <div v-if="status === 'pending'" class="text-center py-16 text-gray-500">
      <p>Loading your stories...</p>
    </div>

    <div v-else-if="status === 'error'" class="text-center py-16 text-red-500">
      <p>Error loading blogs: {{ error?.message }}</p>
    </div>

    <div v-else-if="status === 'success' && blogs.length === 0" class="text-center py-16 text-gray-500">
      <p>You haven't created any stories yet.</p>
    </div>

    <div v-else class="grid md:grid-cols-2 gap-6">
      <div v-for="blog in blogs" :key="blog.id" class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ blog.title }}</h3>
        <p class="text-sm text-gray-600 mb-4">{{ blog.excerpt }}</p>

        <div class="flex items-center justify-between text-sm text-gray-500">
          <span>{{ formatTimeAgo(blog.created_at) }}</span>
          <div class="flex items-center gap-2">
            <button @click="handleEdit(blog.id)" class="text-purple-500 hover:text-purple-700 hover:bg-purple-100 p-2 rounded-full transition-colors">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
              </svg>
            </button>
            <button @click="handleDelete(blog.id)" :disabled="deletingBlogId === blog.id" class="text-red-500 hover:text-red-700 hover:bg-red-100 p-2 rounded-full transition-colors disabled:opacity-50">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div v-if="hasNextPage" class="mt-8 text-center">
      <button @click="loadMore" :disabled="isFetchingNextPage" class="bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-full hover:bg-gray-100 transition-colors">
        {{ isFetchingNextPage ? 'Loading...' : 'Load More' }}
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import useUserBlogs from '../../composables/useUserBlogs'

const {
  blogs,
  status,
  error,
  deletingBlogId,
  handleDelete,
  handleEdit,
  formatTimeAgo,
  hasNextPage,
  isFetchingNextPage,
  loadMore
} = useUserBlogs()
</script>