import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { createPinia } from 'pinia'
import { VueQueryPlugin } from '@tanstack/vue-query'
import { initTabWatcher } from '@/utils/tabWatcher'
import './assets/main.css'

// Toast plugin (can be lazy-loaded as component)
import Toast from "vue-toastification"
import "vue-toastification/dist/index.css"

// Apollo client
import { ApolloClient, InMemoryCache, HttpLink } from '@apollo/client/core'
import { DefaultApolloClient } from '@vue/apollo-composable'

// Echo plugin (must be imported normally)
import '@/plugins/echo'

export const apolloClient = new ApolloClient({
  link: new HttpLink({ uri: import.meta.env.VITE_GRAPHQL_URL }),
  cache: new InMemoryCache(),
})

const app = createApp(App)
app.provide(DefaultApolloClient, apolloClient)
app.use(createPinia())
app.use(router)
app.use(VueQueryPlugin)

// Toast
const options = {
  position: "top-right",
  timeout: 3000,
  closeOnClick: true,
  pauseOnHover: true,
  draggable: true,
}

// Echo plugin
app.use(Toast, options)

// Tab watcher
initTabWatcher()

app.mount('#app')
