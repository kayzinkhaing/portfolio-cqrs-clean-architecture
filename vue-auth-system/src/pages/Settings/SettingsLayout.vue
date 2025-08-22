<template>
  <div class="flex min-h-screen bg-gradient-to-br from-gray-50 via-white to-purple-50">
    <!-- Modern Sidebar with glassmorphism -->
    <aside
      class="w-72 bg-white/70 backdrop-blur-xl shadow-2xl flex flex-col border-r border-white/20 animate-slide-in relative"
    >
      <!-- Decorative gradient overlay -->
      <div
        class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-500/5 rounded-r-3xl"
      ></div>

      <!-- Header with modern styling -->
      <div class="relative p-6 border-b border-gray-200/50">
        <div class="flex items-center gap-3">
          <div
            class="w-10 h-10 bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl flex items-center justify-center shadow-lg"
          >
            <svg
              class="w-5 h-5 text-white"
              fill="none"
              stroke="currentColor"
              stroke-width="2.5"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>
          </div>
          <h2
            class="text-xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent"
          >
            Settings
          </h2>
        </div>
      </div>

      <!-- Navigation Links -->
      <nav class="flex flex-col p-6 space-y-3 flex-1 relative z-10">
        <RouterLink
          v-for="link in links"
          :key="link.name"
          :to="link.to"
          class="group relative px-4 py-3 rounded-2xl flex items-center gap-3 font-medium transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-lg"
          :class="{
            'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg shadow-purple-500/25':
              $route.name === link.to.name,
            'text-gray-600 hover:bg-white hover:text-purple-700 hover:shadow-purple-500/10':
              $route.name !== link.to.name,
          }"
        >
          <!-- Active glow -->
          <div
            v-if="$route.name === link.to.name"
            class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl blur opacity-30"
          ></div>

          <!-- Icon -->
          <component
            :is="link.icon"
            class="w-5 h-5 relative z-10 transition-transform duration-300 group-hover:scale-110"
            :class="{
              'text-white': $route.name === link.to.name,
              'text-purple-600': $route.name !== link.to.name,
            }"
          />
          <span class="relative z-10">{{ link.name }}</span>

          <!-- Hover glow -->
          <div
            v-if="$route.name !== link.to.name"
            class="absolute -inset-1 bg-gradient-to-r from-purple-100 to-pink-100 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"
          ></div>
        </RouterLink>
      </nav>

      <!-- Logout -->
      <div class="p-6 border-t border-gray-200/50 relative z-10">
        <button
          @click="handleLogout"
          class="group w-full flex items-center gap-3 px-4 py-3 rounded-2xl bg-gradient-to-r from-red-50 to-orange-50 text-red-600 hover:from-red-500 hover:to-orange-500 hover:text-white transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-lg hover:shadow-red-500/25"
        >
          <LogoutIcon
            class="w-5 h-5 transition-transform duration-300 group-hover:scale-110"
          />
          <span class="font-medium">Logout</span>
        </button>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 animate-fade-in">
      <div class="max-w-5xl mx-auto">
        <div
          class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 min-h-[600px] relative overflow-hidden"
        >
          <!-- Decorative -->
          <div
            class="absolute top-0 right-0 w-72 h-72 bg-gradient-to-br from-purple-400/10 to-pink-400/10 rounded-full blur-3xl"
          ></div>
          <div
            class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-blue-400/10 to-purple-400/10 rounded-full blur-3xl"
          ></div>

          <!-- Content -->
          <div class="relative z-10 p-8">
            <RouterView />
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { useAuthStore } from '../../stores/auth'
import { useRouter } from 'vue-router'
import { defineAsyncComponent } from 'vue'

// Lazy-load icons
const InformationCircleIcon = defineAsyncComponent(() =>
  import('@heroicons/vue/24/outline/InformationCircleIcon.js')
)
const ShieldCheckIcon = defineAsyncComponent(() =>
  import('@heroicons/vue/24/outline/ShieldCheckIcon.js')
)
const DocumentTextIcon = defineAsyncComponent(() =>
  import('@heroicons/vue/24/outline/DocumentTextIcon.js')
)
const LogoutIcon = defineAsyncComponent(() =>
  import('@heroicons/vue/24/outline/ArrowRightOnRectangleIcon.js')
)

const router = useRouter()
const auth = useAuthStore()

// Use named routes instead of raw paths
const links = [
  { name: 'Information', to: { name: 'SettingsInfo' }, icon: InformationCircleIcon },
  { name: 'Two-Factor Authentication', to: { name: 'Settings2FA' }, icon: ShieldCheckIcon },
  { name: 'Your Blogs', to: { name: 'SettingsBlogs' }, icon: DocumentTextIcon },
]

const handleLogout = async () => {
  await auth.logoutUser()
  router.push('/login')
}
</script>

<style scoped>
@keyframes slide-in {
  from {
    transform: translateX(-100%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}
.animate-slide-in {
  animation: slide-in 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(20px) scale(0.98);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}
.animate-fade-in {
  animation: fade-in 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}
</style>
