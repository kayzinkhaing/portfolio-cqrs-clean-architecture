// src/router/index.ts
import { createRouter, createWebHistory, RouteRecordRaw, RouteLocationNormalized, NavigationGuardNext } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import BlogListView from '@/views/BlogListView.vue'
import LoginView from '@/views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import ProfileView from '@/views/ProfileView.vue'
import EditBlogView from '@/views/EditBlogView.vue'
import CreateBlogView from '@/views/CreateBlogView.vue'

import { authGuard } from '@/middleware/auth'
import { applyMiddleware } from '@/middleware'
import type { Middleware } from '@/middleware/types'

// Extend Vue Router route meta type
interface RouteMetaWithMiddleware {
  middlewares?: Middleware[]
}

// Type-safe routes
const routes: Array<RouteRecordRaw & { meta?: RouteMetaWithMiddleware }> = [
  { path: '/', name: 'Home', component: HomeView },
  { path: '/login', name: 'Login', component: LoginView },
  { path: '/register', name: 'Register', component: RegisterView },
  { path: '/blogs', name: 'BlogList', component: BlogListView },
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
  // {
  //   path: '/profile',
  //   name: 'Profile',
  //   component: ProfileView,
  //   meta: { middlewares: [authGuard] },
  // },
  {
    path: '/settings',
    component: () => import('@/views/Settings/SettingsLayout.vue'),
    meta: { requiresAuth: true },
    children: [
      { path: 'info', component: () => import('@/views/Settings/InformationView.vue') },
      { path: 'profile-edit', component: () => import('@/views/Settings/ProfileEdit.vue') },
      { path: '2fa', component: () => import('@/views/Settings/TwoFactor.vue') },
      { path: 'blogs', component: () => import('@/views/Settings/Blogs.vue') },
    ]
  },
  {
    path: '/forgot-password',
    name: 'ForgotPassword',
    component: () => import('@/views/ForgotPasswordView.vue'),
  },
  {
    path: '/reset-password',
    name: 'ResetPassword',
    component: () => import('@/views/ResetPasswordView.vue')
  },
  {
      path: '/2fa',
      name: 'TwoFactor',
      component: () => import('@/views/TwoFactorView.vue'),
      meta: { middlewares: [authGuard] } // user must be logged in first
    }


]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Type-safe dynamic middleware per route
router.beforeEach((to: RouteLocationNormalized, from: RouteLocationNormalized, next: NavigationGuardNext) => {
  const middlewares = (to.meta as RouteMetaWithMiddleware)?.middlewares || []
  if (middlewares.length > 0) {
    applyMiddleware(middlewares, to, from, next)
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
