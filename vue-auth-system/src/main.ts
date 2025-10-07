// src/main.ts
import { createApp, type App, defineAsyncComponent } from 'vue'
import AppComponent from './App.vue'
import router from './router'
import { createPinia } from 'pinia'
import './assets/tailwind.css'

// Apollo Client (lazy-load)
let apolloClientLoaded = false
export let apolloClient: any = null
export async function initApollo(app: App) {
  if (!apolloClientLoaded) {
    const { ApolloClient, InMemoryCache, HttpLink } = await import('@apollo/client/core')
    const { DefaultApolloClient } = await import('@vue/apollo-composable')

    apolloClient = new ApolloClient({
      link: new HttpLink({ uri: import.meta.env.VITE_GRAPHQL_URL }),
      cache: new InMemoryCache(),
    })

    app.provide(DefaultApolloClient, apolloClient)
    apolloClientLoaded = true
  }
}

// Main app instance
const app = createApp(AppComponent)
app.use(createPinia())
app.use(router)

// Lazy-init plugins
let toastLoaded = false
export async function useToast(appInstance: App) {
  if (!toastLoaded) {
    const { default: Toast } = await import('vue-toastification')
    await import('vue-toastification/dist/index.css')
    appInstance.use(Toast, {
      position: 'top-right',
      timeout: 3000,
      closeOnClick: true,
      pauseOnHover: true,
      draggable: true,
    })
    toastLoaded = true
  }
}

let vueQueryLoaded = false
export async function initVueQuery(appInstance: App) {
  if (!vueQueryLoaded) {
    const { VueQueryPlugin } = await import('@tanstack/vue-query')
    appInstance.use(VueQueryPlugin)
    vueQueryLoaded = true
  }
}

let echoLoaded = false
export async function initEcho() {
  if (!echoLoaded) {
    await import('@/plugins/echo')
    echoLoaded = true
  }
}

// Tab watcher (small utility, safe to load immediately)
import { initTabWatcher } from '@/utils/tabWatcher'
initTabWatcher()

app.mount('#app')
