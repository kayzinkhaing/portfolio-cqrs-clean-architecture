<script setup>
import Navbar from '@/components/Navbar.vue'
</script>

<template>
  <div>
    <Navbar />
    <main class="p-6">
      <router-view />
    </main>
  </div>
</template>
