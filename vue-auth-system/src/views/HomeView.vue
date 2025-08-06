<template>
  <div class="max-w-4xl mx-auto mt-10 px-4">
    <h1 class="text-3xl font-bold mb-6 text-center">Latest Blog Posts</h1>
  
    <div v-if="loading" class="text-center text-gray-500">Loading posts...</div>
  
    <div v-else>
      <div v-for="post in posts" :key="post.id" class="mb-6 p-6 border rounded-md shadow hover:shadow-lg transition">
        <h2 class="text-xl font-semibold mb-2 text-indigo-600">{{ post.title }}</h2>
        <p class="text-gray-700 mb-2">{{ post.excerpt }}</p>
        <small class="text-gray-400">{{ formatDate(post.published_at) }}</small>
      </div>
  
      <div v-if="posts.length === 0" class="text-center text-gray-500">
        No posts found.
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

// Sample: Replace this with your real API call
const fetchPosts = async () => {
  // Simulate API call delay
  return new Promise((resolve) => {
    setTimeout(() => {
      resolve([
        {
          id: 1,
          title: 'How to Build a Vue 3 App',
          excerpt: 'Learn the basics of Vue 3 and how to build a scalable app...',
          published_at: '2025-08-01T10:00:00Z',
        },
        {
          id: 2,
          title: 'Understanding Reactivity in Vue',
          excerpt: 'Reactivity is a core concept in Vue.js. Let’s explore how it works...',
          published_at: '2025-07-25T15:30:00Z',
        },
      ])
    }, 1000)
  })
}

const posts = ref([])
const loading = ref(true)

onMounted(async () => {
  posts.value = await fetchPosts()
  loading.value = false
})

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' }
  return new Date(dateString).toLocaleDateString(undefined, options)
}
</script>
