// src/router/index.ts
import {
  createRouter,
  createWebHistory,
  RouteRecordRaw,
  RouteLocationNormalized,
  NavigationGuardNext,
} from 'vue-router'

// Views
import HomeView from '@/views/HomeView.vue'
import BlogListView from '@/views/BlogListView.vue'
import LoginView from '@/views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import EditBlogView from '@/views/EditBlogView.vue'
import CreateBlogView from '@/views/CreateBlogView.vue'

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
    component: () => import('@/views/Settings/SettingsLayout.vue'),
    meta: { middlewares: [authGuard] }, // protect parent
    children: [
      { path: 'info', name: 'SettingsInfo', component: () => import('@/views/Settings/InformationView.vue') },
      { path: 'profile-edit', name: 'SettingsProfileEdit', component: () => import('@/views/Settings/ProfileEdit.vue') },
      { path: '2fa', name: 'Settings2FA', component: () => import('@/views/Settings/TwoFactor.vue') },
      { path: 'blogs', name: 'SettingsBlogs', component: () => import('@/views/Settings/Blogs.vue') },
    ],
  },
  
  // Auth utilities
  {
    path: '/forgot-password',
    name: 'ForgotPassword',
    component: () => import('@/views/ForgotPasswordView.vue'),
  },
  {
    path: '/reset-password',
    name: 'ResetPassword',
    component: () => import('@/views/ResetPasswordView.vue'),
  },

  // Two-Factor Auth (protected — only logged-in users should see this)
  {
    path: '/2fa',
    name: 'TwoFactor',
    component: () => import('@/views/TwoFactorView.vue'),
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


/* import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import BlogListView from '@/views/BlogListView.vue'
import LoginView from '@/views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import ProfileView from '@/views/ProfileView.vue'
import EditBlogView from '@/views/EditBlogView.vue'
import CreateBlogView from '@/views/CreateBlogView.vue'
import { authGuard } from '@/middleware/auth'

const routes = [
  { path: '/', name: 'Home', component: HomeView },
  { path: '/login', name: 'Login', component: LoginView },
  { path: '/register', name: 'Register', component: RegisterView },
  { path: '/blogs', name: 'BlogList', component: BlogListView },
  { path: '/create-blog', name: 'CreateBlog', component: CreateBlogView, meta: { requiresAuth: true }},
  { path: '/edit-blog/:id', name: 'EditBlog', component: EditBlogView, meta: { requiresAuth: true }},
  { path: '/profile', name: 'Profile', component: ProfileView, meta: { requiresAuth: true }},
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Use dynamic middleware
router.beforeEach((to, from, next) => {
  authGuard(to, from, next)
})

export default router
*/
