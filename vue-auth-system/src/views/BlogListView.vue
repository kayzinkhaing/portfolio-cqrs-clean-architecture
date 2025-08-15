<template>
  <div class="min-h-screen bg-gradient-to-br from-pink-50 via-purple-50 to-indigo-50">
    <div class="max-w-7xl mx-auto py-12 px-4">
      <div class="text-center mb-16">
        <div class="inline-flex items-center gap-3 bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-semibold mb-6 shadow-lg">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          Fresh Stories Daily
        </div>
        
        <h1 class="text-5xl md:text-6xl font-black text-gray-900 mb-4 tracking-tight">
          Trending <span class="bg-gradient-to-r from-pink-500 to-purple-600 bg-clip-text text-transparent">Stories</span>
        </h1>
        
        <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-8">
          Discover amazing content from our creative community
        </p>

        <router-link v-if="canAddBlog" to="/create-blog"
          class="group inline-flex items-center gap-3 bg-gradient-to-r from-pink-500 to-purple-600 text-white px-8 py-4 rounded-2xl text-lg font-bold shadow-xl hover:shadow-2xl hover:shadow-pink-500/25 transition-all duration-300 hover:-translate-y-1 hover:scale-105">
          <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
          </div>
          <span>Create Story</span>
          <div class="w-2 h-2 bg-white rounded-full opacity-60 group-hover:opacity-100 transition-opacity"></div>
        </router-link>
      </div>

      <div v-if="status === 'error'"
        class="max-w-md mx-auto bg-red-100 border-2 border-red-200 text-red-700 px-6 py-4 rounded-3xl text-center mb-8 shadow-lg">
        <div class="text-2xl mb-2">😕</div>
        {{ error?.message || errorStore.generalMessage || 'Oops! Something went wrong.' }}
      </div>

      <div v-else-if="status === 'success' && blogs.length === 0" 
        class="text-center py-16">
        <div class="text-8xl mb-4">📝</div>
        <h3 class="text-2xl font-bold text-gray-700 mb-2">No stories yet!</h3>
        <p class="text-gray-500">Be the first to share something amazing</p>
      </div>

      <div v-else-if="status === 'success'" class="grid lg:grid-cols-2 gap-8 mb-12">
        <div v-for="blog in blogs" :key="blog.id" 
          class="group bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100">
          
          <div class="h-64 bg-gradient-to-br from-pink-200 via-purple-200 to-indigo-200 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-pink-500/20 to-purple-600/20"></div>
            <div class="absolute inset-0 flex items-center justify-center">
              <div class="text-6xl opacity-30">📖Blog Image</div>
            </div>
            <div class="absolute top-4 left-4 flex gap-2">
              <span class="bg-white/90 backdrop-blur-sm text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">
                Story
              </span>
            </div>
            <div v-if="isBlogOwner(blog)" class="absolute top-4 right-4">
              <span class="bg-pink-500 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Mine
              </span>
            </div>
          </div>

          <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
              <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                {{ blog.user?.name?.charAt(0)?.toUpperCase() || '?' }}
              </div>
              <div>
                <div class="font-semibold text-gray-900">{{ blog.user?.name || 'Anonymous' }}</div>
                 <div class="text-sm text-gray-500">{{ formatTimeAgo(blog.created_at) }}</div>
                 <div>
            
          </div>
              </div>
            </div>

            <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-purple-600 transition-colors">
              {{ blog.title || 'Untitled Story' }}
            </h2>

            <p class="text-gray-600 mb-4 line-clamp-3">
              {{ blog.excerpt || 'An amazing story waiting to be discovered...' }}
            </p>

            <div class="flex items-center justify-between">
              <div class="flex items-center gap-4 text-sm text-gray-500">
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                  </svg>
                  24
                </span>
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                  </svg>
                  8
                </span>
              </div>

                <div v-if="isBlogOwner(blog)" class="flex items-center gap-2">
                <button @click="handleEdit(blog.id)"
                  class="flex items-center gap-1 bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold hover:bg-purple-200 transition-all duration-200">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                  </svg>
                  Edit
                </button>
                
                <button @click="handleDelete(blog.id)"
                  :disabled="deletingBlogId === blog.id"
                  class="flex items-center gap-1 bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold hover:bg-red-200 transition-all duration-200 disabled:opacity-50">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                  </svg>
                  Delete
                </button>
                </div>
              
            </div>
          </div>
        </div>
      </div>

      <div v-if="canLoadMore" class="text-center">
        <button @click="loadMore" :disabled="isFetchingNextPage"
          class="group inline-flex items-center gap-3 bg-white border-2 border-purple-200 text-purple-600 px-8 py-4 rounded-2xl text-lg font-bold hover:bg-purple-50 hover:border-purple-300 transition-all duration-300 hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg">
          <svg class="w-5 h-5 group-hover:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
          </svg>
          <span>{{ isFetchingNextPage ? 'Loading amazing stories...' : 'Show More Stories' }}</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import useBlogs from '../composables/useBlogs'

const {
  blogs,
  status,
  error,
  errorStore,
  auth,
  currentUserId,
  handleEdit, 
  handleDelete,
  deletingBlogId,
  hasNextPage,
  isFetchingNextPage,
  loadMore,
  formatTimeAgo
} = useBlogs()

const canAddBlog = computed(() => status.value === 'success' && auth.isAuthenticated)
const canLoadMore = computed(() => hasNextPage.value && status.value === 'success')

const isBlogOwner = (blog: any) => auth.isAuthenticated && blog.user?.id === currentUserId.value
</script>