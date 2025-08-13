// src/stores/auth.ts
import { defineStore } from 'pinia'
import {
  login,
  logout,
  getProfile,
  register,
  setAuthToken,
} from '@/services/api'

export interface User {
  id: string | number
  name: string
  email: string
  township_id?: string | number
  ward_id?: string | number
}

interface AuthState {
  user: User | null
  token: string | null
  loading: boolean
  error: string | null
  initialized: boolean
}

export interface Credentials {
  email: string
  password: string
}

export const useAuthStore = defineStore('auth', {
  state: (): AuthState => ({
    user: null,
    token: localStorage.getItem('token'),
    loading: false,
    error: null,
    initialized: false,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token && !!state.user,
    userId: (state) => state.user?.id ?? null,
  },

  actions: {
    setToken(token: string | null) {
      this.token = token
      if (token) {
        localStorage.setItem('token', token)
        setAuthToken(token)
      } else {
        localStorage.removeItem('token')
        setAuthToken(null)
      }
    },

    setUser(user: User | null) {
      this.user = user
    },

    async initialize() {
      if (this.token) {
        setAuthToken(this.token)
        await this.fetchUser()
      }
      this.initialized = true
    },

    async loginUser(credentials: Credentials) {
      this.loading = true
      this.error = null
      try {
        const res = await login(credentials)
        this.setToken(res.data.data.token)
        await this.fetchUser()
      } catch (err: any) {
        this.error = err.response?.data?.message || 'Login failed'
        this.setToken(null)
        this.setUser(null)
        throw err
      } finally {
        this.loading = false
      }
    },

    async fetchUser() {
      if (!this.token) {
        this.setToken(null)
        this.setUser(null)
        return
      }
      try {
        const res = await getProfile()
        this.user = res.data
      } catch {
        this.setToken(null)
        this.setUser(null)
      }
    },

    async logoutUser() {
      try {
        await logout()
      } catch (err) {
        console.warn('Logout API call failed:', err)
      }
      this.setToken(null)
      this.setUser(null)
    },
  },
})
