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

// ✅ Import Apollo Client
import { ApolloClient, InMemoryCache, HttpLink } from '@apollo/client/core'
import { DefaultApolloClient } from '@vue/apollo-composable'

// ✅ Import Echo plugin
import '@/plugins/echo'  // <-- ADD THIS LINE

// Apollo client instance
export const apolloClient = new ApolloClient({
  link: new HttpLink({
    uri: import.meta.env.VITE_GRAPHQL_URL,
  }),
  cache: new InMemoryCache(),
})

const app = createApp(App)
app.provide(DefaultApolloClient, apolloClient)
app.use(createPinia())
app.use(router)
app.use(VueQueryPlugin)

// ✅ Toast options
const options = {
  position: "top-right",
  timeout: 3000,
  closeOnClick: true,
  pauseOnHover: true,
  draggable: true,
}

app.use(Toast, options)

// Initialize tab watcher globally
initTabWatcher()

app.mount('#app')
