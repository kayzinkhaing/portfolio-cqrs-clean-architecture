import { useAuthStore } from '@/stores/auth'
import type { NavigationGuardNext, RouteLocationNormalized } from 'vue-router'

export async function authGuard(
  to: RouteLocationNormalized,
  from: RouteLocationNormalized,
  next: NavigationGuardNext
) {
  const auth = useAuthStore()

  // Initialize auth if not yet initialized
  if (!auth.initialized) {
    try {
      await auth.initialize()
    } catch (err) {
      console.error('Auth initialization failed:', err)
    }
  }

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
