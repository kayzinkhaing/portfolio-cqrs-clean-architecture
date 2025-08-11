import { defineStore } from 'pinia'
import {
  login,
  logout,
  getProfile,
  register,
  setAuthToken,
} from '@/services/api'

interface User {
  name: string
  email: string
  township_id?: string | number
  ward_id?: string | number
  // ...other fields
}

interface AuthState {
  user: User | null
  token: string
  loading: boolean
  error: string | null
  initialized: boolean
}

interface Credentials {
  email: string
  password: string
}

export const useAuthStore = defineStore('auth', {
  state: (): AuthState => ({
    user: null,
    token: localStorage.getItem('token') || '',
    loading: false,
    error: null,
    initialized: false,
  }),
  getters: {
    isAuthenticated: (state): boolean => !!state.token && !!state.user,
  },
  actions: {
    setToken(token: string): void {
      this.token = token
      localStorage.setItem('token', token)
      setAuthToken(token)
    },
    setUser(user: User): void {
      this.user = user
    },
    async initialize(): Promise<void> {
      if (this.token) {
        setAuthToken(this.token)
        await this.fetchUser()
      }
      this.initialized = true
    },
    clearAuth(): void {
      this.user = null
      this.token = ''
      localStorage.removeItem('token')
      setAuthToken(null)
    },
    async loginUser(credentials: Credentials): Promise<void> {
      this.loading = true
      this.error = null
      try {
        const res = await login(credentials)
        this.setToken(res.data.data.token)
        await this.fetchUser()
      } catch (err: any) {
        this.error = err.response?.data?.message || 'Login failed'
        this.clearAuth()
        throw err
      } finally {
        this.loading = false
      }
    },
    async fetchUser(): Promise<void> {
      if (!this.token) {
        this.clearAuth()
        this.initialized = true
        return
      }
      try {
        const res = await getProfile()
        this.user = res.data
      } catch {
        this.clearAuth()
      } finally {
        this.initialized = true
      }
    },
    async logoutUser(): Promise<void> {
      try {
        await logout()
      } catch (err) {
        console.error('Logout failed', err)
      }
      this.clearAuth()
    },
  },
})
