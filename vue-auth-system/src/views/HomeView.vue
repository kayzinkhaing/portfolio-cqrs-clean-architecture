<template>
  <div class="max-w-4xl mx-auto mt-10 px-4 text-center">
    <h1 class="text-4xl font-bold mb-4 text-indigo-700">Welcome to My Blog</h1>
    <p class="text-gray-600 text-lg mb-6">
      This is a simple blog platform built with Vue.js and Laravel.
    </p>

    <router-link
      to="/blogs"
      class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg text-lg font-medium hover:bg-indigo-700 transition"
    >
      View Latest Blog Posts
    </router-link>
  </div>
</template>

