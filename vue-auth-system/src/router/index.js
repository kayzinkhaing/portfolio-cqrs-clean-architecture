// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import BlogListView from '@/views/BlogListView.vue'
import LoginView from '@/views/LoginView.vue'
import RegisterView from '@/views/RegisterView.vue'
import ProfileView from '@/views/ProfileView.vue'
import EditBlogView from '@/views/EditBlogView.vue'
import CreateBlogView from '@/views/CreateBlogView.vue'
import { useAuthStore } from '@/stores/auth'

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

router.beforeEach((to, from, next) => {
  const auth = useAuthStore()
  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    next('/login')
  } else {
    next()
  }
})

export default router
