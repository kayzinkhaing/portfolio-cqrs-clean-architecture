import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './assets/tailwind.css'
import { createPinia } from 'pinia'
import { useAuthStore } from '@/stores/auth'

const app = createApp(App)
const pinia = createPinia()
app.use(pinia)
app.use(router)

const auth = useAuthStore()

// Call initialize() before mounting
auth.initialize().finally(() => {
  app.mount('#app')
})
