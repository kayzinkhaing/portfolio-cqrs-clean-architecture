declare module 'laravel-echo' {
  import Pusher from 'pusher-js'

  export default class Echo {
    constructor(options: {
      broadcaster: string
      key?: string
      wsHost?: string
      wsPort?: number
      wssPort?: number
      forceTLS?: boolean
      disableStats?: boolean
      enabledTransports?: string[]
      authorizer?: Function
      [key: string]: any
    })

    channel(channel: string): any
    privateChannel(channel: string): any
    listen(event: string, callback: (data: any) => void): this
    leave(channel: string): void
  }
}
