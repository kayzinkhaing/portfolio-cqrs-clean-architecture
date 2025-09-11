// src/plugins/echo.ts
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

declare global {
  interface Window {
    Pusher: typeof Pusher
    Echo: typeof Echo
  }
}

window.Pusher = Pusher

export const echo = new Echo({
  broadcaster: 'pusher',
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
  forceTLS: true,
  encrypted: true,
})

// console.log(import.meta.env.VITE_PUSHER_APP_KEY)
// console.log('***************************************')
// Debug
// console.log('Echo initialized:', {
//   key: import.meta.env.VITE_PUSHER_APP_KEY,
//   cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//   echoInstance: echo,
// })

// console.log('***************************************')

const rawPusher = (echo.connector as any).pusher as Pusher

// rawPusher.connection.bind('state_change', (states: any) => {
//   console.log('🔌 Connection state changed:', states)
// })
