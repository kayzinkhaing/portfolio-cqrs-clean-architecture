import { useAuthStore } from '@/stores/auth'
import type { NavigationGuardNext, RouteLocationNormalized } from 'vue-router'

export async function authGuard(
  to: RouteLocationNormalized,
  from: RouteLocationNormalized,
  next: NavigationGuardNext
) {
  const auth = useAuthStore()

  // Wait for auth to initialize (token refresh etc.)
  if (!auth.initialized) {
    try {
      await auth.initialize()
    } catch (err) {
      console.error('Auth initialization failed:', err)
    }
  }

  // 🚨 If not logged in, redirect to login page
  if (!auth.isAuthenticated) {
    return next({
      path: '/home/login',  // ✅ direct path instead of name
      query: { redirect: to.fullPath },
    })
  }

  // ✅ If logged in but requires 2FA
  if (auth.requires2FA && to.name !== 'TwoFactor') {
    return next({ name: 'TwoFactor' })
  }

  // ✅ Otherwise allow access
  next()
}
