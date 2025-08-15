// src/middleware/auth.ts
import { useAuthStore } from '@/stores/auth'
import type { NavigationGuardNext, RouteLocationNormalized } from 'vue-router'

export function authGuard(
  to: RouteLocationNormalized,
  from: RouteLocationNormalized,
  next: NavigationGuardNext
) {
  const auth = useAuthStore()

  // Not logged in → redirect to login
  if (!auth.isAuthenticated) {
    return next({
      name: 'Login',
      query: { redirect: to.fullPath },
    })
  }

  // Logged in but 2FA required → redirect to /2fa
  if (auth.requires2FA && to.name !== 'TwoFactor') {
    return next({ name: 'TwoFactor' })
  }

  // Otherwise, allow access
  next()
}
