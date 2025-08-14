// src/middleware/types.ts
import type { NavigationGuardNext, RouteLocationNormalized } from 'vue-router'

export type Middleware = (
  to: RouteLocationNormalized,
  from: RouteLocationNormalized,
  next: NavigationGuardNext
) => void

// Extend Vue Router meta to include middlewares
export interface RouteMetaWithMiddleware {
  middlewares?: Middleware[]
  requiresAuth?: boolean
  roles?: string[]
}
