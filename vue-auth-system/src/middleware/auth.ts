// src/middleware/auth.ts
import { useAuthStore } from '@/stores/auth'
import type { NavigationGuardNext, RouteLocationNormalized } from 'vue-router'

/**
 * Auth middleware
 * Redirects to login if user is not authenticated
 */
export function authGuard(
  to: RouteLocationNormalized,
  from: RouteLocationNormalized,
  next: NavigationGuardNext
) {
  const auth = useAuthStore()

  if (!auth.isAuthenticated) {
    next({
      name: 'Login',
      query: { redirect: to.fullPath }, // optional: redirect back after login
    })
  } else {
    next()
  }
}
