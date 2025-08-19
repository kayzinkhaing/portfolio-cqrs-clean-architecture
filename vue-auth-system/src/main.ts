import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './assets/tailwind.css'
import { createPinia } from 'pinia'
import { useAuthStore } from '@/stores/auth'
import { VueQueryPlugin } from '@tanstack/vue-query'

const app = createApp(App)

const pinia = createPinia()
app.use(pinia)
app.use(router)
app.use(VueQueryPlugin)

const auth = useAuthStore()

// CQRS: fetch current user before app mounts
auth.initialize().finally(() => {
  app.mount('#app')
})
