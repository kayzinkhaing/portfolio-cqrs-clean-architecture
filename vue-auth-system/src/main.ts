import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './assets/tailwind.css'
import { createPinia } from 'pinia'
import { useAuthStore } from '@/stores/auth'
import { VueQueryPlugin } from '@tanstack/vue-query'

const app = createApp(App)

// setup pinia first
const pinia = createPinia()
app.use(pinia)

// add plugins
app.use(router)
app.use(VueQueryPlugin)

const auth = useAuthStore()

// Wait for auth initialization before mounting app
auth.initialize().finally(() => {
  app.mount('#app')
})
