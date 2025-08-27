import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
// import './assets/tailwind.css'
import { createPinia } from 'pinia'
import { VueQueryPlugin } from '@tanstack/vue-query'
import { initTabWatcher } from '@/utils/tabWatcher'
import './assets/main.css'
const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(VueQueryPlugin)

// Initialize tab watcher globally
initTabWatcher()

app.mount('#app')

// const auth = useAuthStore()

// CQRS: fetch current user before app mounts
// auth.initialize().finally(() => {
//   app.mount('#app')
// })
