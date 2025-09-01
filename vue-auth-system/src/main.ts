import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { createPinia } from 'pinia'
import { VueQueryPlugin } from '@tanstack/vue-query'
import { initTabWatcher } from '@/utils/tabWatcher'
import './assets/main.css'

// ✅ Import toast plugin
import Toast from "vue-toastification"
import "vue-toastification/dist/index.css"

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(VueQueryPlugin)

// ✅ Define options directly
const options = {
  position: "top-right",
  timeout: 3000,
  closeOnClick: true,
  pauseOnHover: true,
  draggable: true,
}

// ✅ Register plugin
app.use(Toast, options)

// Initialize tab watcher globally
initTabWatcher()

app.mount('#app')
