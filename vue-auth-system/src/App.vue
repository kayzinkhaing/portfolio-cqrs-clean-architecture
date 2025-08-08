  <script setup>
  import Navbar from '@/components/Navbar.vue'
  import { useAuthStore } from '@/stores/auth'
  import { onMounted } from 'vue'

  const auth = useAuthStore()

  onMounted(() => {
    auth.initialize()  // starts async fetch but does NOT block rendering
  })
  </script>

  <template>
    <div>
      <Navbar />
      <main class="p-6">
        <router-view />
      </main>
    </div>
  </template>
