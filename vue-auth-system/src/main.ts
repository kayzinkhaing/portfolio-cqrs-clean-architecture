import { createApp, type App } from 'vue'
import AppComponent from './App.vue'
import router from './router'
import { createPinia } from 'pinia'
import './assets/tailwind.css'

import { ApolloClient, InMemoryCache, HttpLink } from '@apollo/client/core'
import { DefaultApolloClient } from '@vue/apollo-composable'

export const apolloClient = new ApolloClient({
  link: new HttpLink({ uri: import.meta.env.VITE_GRAPHQL_URL }),
  cache: new InMemoryCache(),
})

const app = createApp(AppComponent)
app.provide(DefaultApolloClient, apolloClient)
app.use(createPinia())
app.use(router)

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

import { initTabWatcher } from '@/utils/tabWatcher'
initTabWatcher()

app.mount('#app')
