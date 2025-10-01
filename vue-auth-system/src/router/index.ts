// src/router/index.ts - Simplified version that only includes existing files
import {
  createRouter,
  createWebHistory,
  type RouteRecordRaw,
  type RouteLocationNormalized,
  type NavigationGuardNext,
} from 'vue-router'

// Middleware
import { authGuard } from '@/middleware/auth'
import { applyMiddleware } from '@/middleware'
import type { Middleware } from '@/middleware/types'

// Types
interface RouteMetaWithMiddleware {
  middlewares?: Middleware[]
  requiresAuth?: boolean
  title?: string
  layout?: string
}

// Simplified route definitions - only include files that exist
const routes: Array<RouteRecordRaw & { meta?: RouteMetaWithMiddleware }> = [
  // Root redirect
  { 
    path: '/', 
    redirect: '/portfolio' 
  },

  // Keep your existing routes that work
  { 
    path: '/home', 
    name: 'Home', 
    component: () => import('@/pages/HomeView.vue') 
  },
  { 
    path: '/home/login', 
    name: 'Login', 
    component: () => import('@/pages/LoginView.vue') 
  },
  { 
    path: '/home/register', 
    name: 'Register', 
    component: () => import('@/pages/RegisterView.vue') 
  },
  { 
    path: '/home/blogs', 
    name: 'BlogList', 
    component: () => import('@/pages/BlogListView.vue') 
  },
  {
    path: '/create-blog',
    name: 'CreateBlog',
    component: () => import('@/pages/CreateBlogView.vue'),
    meta: { middlewares: [authGuard], requiresAuth: true },
  },
  {
    path: '/edit-blog/:id',
    name: 'EditBlog',
    component: () => import('@/pages/EditBlogView.vue'),
    meta: { middlewares: [authGuard], requiresAuth: true },
  },
  { 
    path: '/forgot-password', 
    name: 'ForgotPassword', 
    component: () => import('@/pages/ForgotPasswordView.vue') 
  },
  { 
    path: '/reset-password', 
    name: 'ResetPassword', 
    component: () => import('@/pages/ResetPasswordView.vue') 
  },
  {
    path: '/2fa',
    name: 'TwoFactor',
    component: () => import('@/pages/TwoFactorView.vue'),
    meta: { middlewares: [authGuard], requiresAuth: true },
  },

  // Portfolio routes
  {
    path: '/portfolio',
    component: () => import('@/pages/Portfolio/PortfolioLayout.vue'),
    children: [
      {
        path: '',
        name: 'PortfolioHome',
        component: () => import('@/pages/Portfolio/HomeView.vue'),
        meta: { title: 'Kay Zin Khaing - Full Stack Developer' },
      },
      { 
        path: 'about', 
        name: 'About', 
        component: () => import('@/pages/Portfolio/AboutView.vue'), 
        meta: { title: 'About - Kay Zin Khaing' } 
      },
      { 
        path: 'skills', 
        name: 'Skills', 
        component: () => import('@/pages/Portfolio/SkillsView.vue'), 
        meta: { title: 'Skills - Kay Zin Khaing' } 
      },
      { 
        path: 'education', 
        name: 'Education', 
        component: () => import('@/pages/Portfolio/EducationView.vue'), 
        meta: { title: 'Education - Kay Zin Khaing' } 
      },
      { 
        path: 'work', 
        name: 'Work', 
        component: () => import('@/pages/Portfolio/WorkView.vue'), 
        meta: { title: 'Projects - Kay Zin Khaing' } 
      },
      { 
        path: 'experience', 
        name: 'Experience', 
        component: () => import('@/pages/Portfolio/ExperienceView.vue'), 
        meta: { title: 'Experience - Kay Zin Khaing' } 
      },
      { 
        path: 'site-technologies', 
        name: 'SiteTechnologies', 
        component: () => import('@/pages/Portfolio/SiteTechnologiesView.vue'), 
        meta: { title: 'Site Technologies - Kay Zin Khaing' } 
      },
      { 
        path: 'hire-me', 
        name: 'HireMe', 
        component: () => import('@/pages/Portfolio/HireMeView.vue'), 
        meta: { title: 'Hire Me - Kay Zin Khaing' } 
      },
    ],
  },

  // Dashboard routes (protected)
  {
    path: '/dashboard',
    component: () => import('@/pages/Dashboard/DashboardLayout.vue'),
    meta: { middlewares: [authGuard], requiresAuth: true },
    children: [
      { 
        path: '', 
        name: 'DashboardHome', 
        component: () => import('@/pages/Dashboard/DashboardHome.vue'),
        meta: { title: 'Dashboard Overview' }
      },
      { 
        path: 'projects', 
        name: 'DashboardProjects', 
        component: () => import('@/pages/Dashboard/Projects/ProjectList.vue'),
        meta: { title: 'Manage Projects' }
      },
      {
        path: 'projects/create',
        name: 'DashboardProjectCreate',
        component: () => import('@/pages/Dashboard/Projects/CreateProject.vue'),
        meta: { title: 'Create Project' }
      },
      {
        path: 'projects/edit/:id',
        name: 'DashboardProjectEdit',
        component: () => import('@/pages/Dashboard/Projects/EditProject.vue'),
        meta: { title: 'Edit Project' },
        props: true
      },
      { 
        path: 'education', 
        name: 'DashboardEducation', 
        component: () => import('@/pages/Dashboard/Education/EducationList.vue'),
        meta: { title: 'Manage Education' }
      },
      {
        path: 'education/edit/:id',
        name: 'DashboardEducationEdit',
        component: () => import('@/pages/Dashboard/Education/EditEducation.vue'),
        meta: { title: 'Edit Education' }
      },
      { 
        path: 'experience', 
        name: 'DashboardExperience', 
        component: () => import('@/pages/Dashboard/Experience/ExperienceList.vue'),
        meta: { title: 'Manage Experience' }
      },
      { 
        path: 'hire-me', 
        name: 'DashboardHireMe', 
        component: () => import('@/pages/Dashboard/HireMe/HireMeList.vue'),
        meta: { title: 'Hire Requests' }
      },
      { 
        path: 'settings/:tab?', 
        name: 'DashboardSettings', 
        component: () => import('@/pages/Dashboard/Settings/SettingsPage.vue'),
        meta: { title: 'Settings' }
      },
    ],
  },

  // 404 Not Found - now using the file we just created
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: () => import('@/pages/NotFoundView.vue'),
    meta: { title: '404 - Page Not Found' }
  }
]

// Router instance
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL || '/'),
  routes,
  scrollBehavior() {
    // ✅ Prevent forced reflow by avoiding geometry reads
    // No savedPosition or DOM measurement
    return new Promise((resolve) => {
      // Defer scroll until after next frame
      requestAnimationFrame(() => {
        resolve({ left: 0, top: 0 })
      })
    })
  },
})

// Global navigation guard
router.beforeEach((to: RouteLocationNormalized, from: RouteLocationNormalized, next: NavigationGuardNext) => {
  // Set page title
  if (to.meta?.title) {
    document.title = to.meta.title as string
  }

  // Apply middlewares
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

// Types export for use in other files
export type { RouteMetaWithMiddleware }