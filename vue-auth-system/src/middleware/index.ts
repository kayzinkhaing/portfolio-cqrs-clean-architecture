// src/middleware/index.ts
import type { NavigationGuardNext, RouteLocationNormalized } from 'vue-router'
import { Middleware } from './types'

export function applyMiddleware(
  middlewares: Middleware[],
  to: RouteLocationNormalized,
  from: RouteLocationNormalized,
  next: NavigationGuardNext
) {
  const stack = [...middlewares]

  const run = () => {
    const middleware = stack.shift()
    if (!middleware) return next()
    middleware(to, from, () => run())
  }

  run()
}
