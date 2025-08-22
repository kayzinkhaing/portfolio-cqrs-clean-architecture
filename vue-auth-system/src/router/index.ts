// src/router/index.ts
import {
  createRouter,
  createWebHistory,
  RouteRecordRaw,
  RouteLocationNormalized,
  NavigationGuardNext,
} from 'vue-router'

// pages
import HomeView from '@/pages/HomeView.vue'
import BlogListView from '@/pages/BlogListView.vue'
import LoginView from '@/pages/LoginView.vue'
import RegisterView from '@/pages/RegisterView.vue'
import EditBlogView from '@/pages/EditBlogView.vue'
import CreateBlogView from '@/pages/CreateBlogView.vue'

// Middleware
import { authGuard } from '@/middleware/auth'
import { applyMiddleware } from '@/middleware'
import type { Middleware } from '@/middleware/types'

// Extend Vue Router meta type
interface RouteMetaWithMiddleware {
  middlewares?: Middleware[]
  requiresAuth?: boolean
}

// Define routes
const routes: Array<RouteRecordRaw & { meta?: RouteMetaWithMiddleware }> = [
  { path: '/', name: 'Home', component: HomeView },
  { path: '/login', name: 'Login', component: LoginView },
  { path: '/register', name: 'Register', component: RegisterView },
  { path: '/blogs', name: 'BlogList', component: BlogListView },

  // Protected blog routes
  {
    path: '/create-blog',
    name: 'CreateBlog',
    component: CreateBlogView,
    meta: { middlewares: [authGuard] },
  },
  {
    path: '/edit-blog/:id',
    name: 'EditBlog',
    component: EditBlogView,
    meta: { middlewares: [authGuard] },
  },

// Settings (protected parent + nested children)
  {
    path: '/settings',
    component: () => import('@/pages/Settings/SettingsLayout.vue'),
    meta: { middlewares: [authGuard] }, // protect parent
    children: [
      { path: 'info', name: 'SettingsInfo', component: () => import('@/pages/Settings/InformationView.vue') },
      { path: 'profile-edit', name: 'SettingsProfileEdit', component: () => import('@/pages/Settings/ProfileEdit.vue') },
      { path: '2fa', name: 'Settings2FA', component: () => import('@/pages/Settings/TwoFactor.vue') },
      { path: 'blogs', name: 'SettingsBlogs', component: () => import('@/pages/Settings/Blogs.vue') },
    ],
  },
  
  // Auth utilities
  {
    path: '/forgot-password',
    name: 'ForgotPassword',
    component: () => import('@/pages/ForgotPasswordView.vue'),
  },
  {
    path: '/reset-password',
    name: 'ResetPassword',
    component: () => import('@/pages/ResetPasswordView.vue'),
  },

  // Two-Factor Auth (protected — only logged-in users should see this)
  {
    path: '/2fa',
    name: 'TwoFactor',
    component: () => import('@/pages/TwoFactorView.vue'),
    meta: { middlewares: [authGuard] },
  },
]

// Create router
const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Global middleware handler
router.beforeEach((to: RouteLocationNormalized, from: RouteLocationNormalized, next: NavigationGuardNext) => {
  // Collect middlewares from all matched routes (parent + child)
  const middlewareList = to.matched.flatMap(
    (r) => (r.meta as RouteMetaWithMiddleware)?.middlewares || []
  )

  if (middlewareList.length > 0) {
    applyMiddleware(middlewareList, to, from, next)
  } else {
    next()
  }
})

export default router

