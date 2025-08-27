import {
  createRouter,
  createWebHistory,
  RouteRecordRaw,
  RouteLocationNormalized,
  NavigationGuardNext,
} from 'vue-router'

// Pages
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

// Portfolio layout (lazy-loaded)
const PortfolioLayout = () => import('@/pages/Portfolio/PortfolioLayout.vue')

// Lazy-loaded portfolio pages
const PortfolioHomeView = () => import('@/pages/Portfolio/HomeView.vue')
const AboutView = () => import('@/pages/Portfolio/AboutView.vue')
const SkillsView = () => import('@/pages/Portfolio/SkillsView.vue')
const EducationView = () => import('@/pages/Portfolio/EducationView.vue')
const WorkView = () => import('@/pages/Portfolio/WorkView.vue')
const ExperienceView = () => import('@/pages/Portfolio/ExperienceView.vue')
const HireMeView = () => import('@/pages/Portfolio/HireMeView.vue')

// Routes
const routes: Array<RouteRecordRaw & { meta?: RouteMetaWithMiddleware }> = [
  // Redirect root to portfolio home
  { path: '/', redirect: '/portfolio' },

  // Auth & blog pages (leading / is required)
  { path: '/home', name: 'Home', component: HomeView },
  { path: '/home/login', name: 'Login', component: LoginView },
  { path: '/home/register', name: 'Register', component: RegisterView },
  { path: '/home/blogs', name: 'BlogList', component: BlogListView },

  // Protected blog routes
  { path: '/create-blog', name: 'CreateBlog', component: CreateBlogView, meta: { middlewares: [authGuard] } },
  { path: '/edit-blog/:id', name: 'EditBlog', component: EditBlogView, meta: { middlewares: [authGuard] } },

  // Settings (nested)
  {
    path: '/settings',
    component: () => import('@/pages/Settings/SettingsLayout.vue'),
    meta: { middlewares: [authGuard] },
    children: [
      { path: 'info', name: 'SettingsInfo', component: () => import('@/pages/Settings/InformationView.vue') },
      { path: 'profile-edit', name: 'SettingsProfileEdit', component: () => import('@/pages/Settings/ProfileEdit.vue') },
      { path: '2fa', name: 'Settings2FA', component: () => import('@/pages/Settings/TwoFactor.vue') },
      { path: 'blogs', name: 'SettingsBlogs', component: () => import('@/pages/Settings/Blogs.vue') },
    ],
  },

  // Auth utilities
  { path: '/forgot-password', name: 'ForgotPassword', component: () => import('@/pages/ForgotPasswordView.vue') },
  { path: '/reset-password', name: 'ResetPassword', component: () => import('@/pages/ResetPasswordView.vue') },

  // Two-Factor Auth
  { path: '/2fa', name: 'TwoFactor', component: () => import('@/pages/TwoFactorView.vue'), meta: { middlewares: [authGuard] } },

  // Portfolio routes (nested under layout)
  {
    path: '/portfolio',
    component: PortfolioLayout,
    children: [
      { path: '', name: 'PortfolioHome', component: PortfolioHomeView ,
        meta: { title: 'Kay Zin Khaing - Full Stack Developer' }},
      { path: 'about', name: 'About', component: AboutView , meta: { title: 'About - Kay Zin Khaing'}},
      { path: 'skills', name: 'Skills', component: SkillsView ,
        meta: { title: 'Skills - Kay Zin Khaing' }},
      { path: 'education', name: 'Education', component: EducationView,
        meta: { title: 'Education - Kay Zin Khaing' } },
      { path: 'work', name: 'Work', component: WorkView ,
        meta: { title: 'Projects - Kay Zin Khaing' }},
      { path: 'experience', name: 'Experience', component: ExperienceView ,
        meta: { title: 'Experience - Kay Zin Khaing' }},
      { path: 'hire-me', name: 'HireMe', component: HireMeView ,
        meta: { title: 'Hire Me - Kay Zin Khaing' }},
    ],
    
  },
  
]

// Create router
const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Global middleware
router.beforeEach((to: RouteLocationNormalized, from: RouteLocationNormalized, next: NavigationGuardNext) => {
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
