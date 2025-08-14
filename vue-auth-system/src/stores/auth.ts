// src/stores/auth.ts
import { defineStore } from 'pinia'
import { login, logout, getProfile, register, updateProfile } from '@/services/auth'
import { setAuthToken } from '@/services/axios'
import type { User } from '@/services/types'

export interface Credentials {
  email: string
  password: string
}
export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null as User | null,
    token: localStorage.getItem('token') || '',
    loading: false,
    error: null as string | null,
    initialized: false,
    errors: {} as Record<string, string>
  }),
  getters: {
    isAuthenticated: state => !!state.token && !!state.user,
  },
  actions: {
    setToken(token: string) {
      this.token = token
      localStorage.setItem('token', token)
      setAuthToken(token)
    },
    setUser(user: User) { this.user = user },
    clearAuth() {
      this.user = null
      this.token = ''
      localStorage.removeItem('token')
      setAuthToken(null)
    },
    async initialize() {
      if (this.token) {
        setAuthToken(this.token)
        await this.fetchUser()
      }
      this.initialized = true
    },
    async loginUser(credentials: { email: string; password: string }) {
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
      } finally { this.loading = false }
    },
    async fetchUser() {
      if (!this.token) { this.clearAuth(); this.initialized = true; return }
      try { const res = await getProfile(); this.user = res.data } 
      catch { this.clearAuth() } 
      finally { this.initialized = true }
    },
    async logoutUser() { try { await logout() } catch {} finally { this.clearAuth() } },
    async updateUserProfile(updates: Partial<User>) {
      if (!this.user) return
      this.loading = true; this.errors = {}
      try {
        const res = await updateProfile(updates)
        this.user = { ...this.user, ...res.data.data }
      } catch (err: any) {
        if (err.response?.status === 422) this.errors = err.response.data.errors
        else throw err
      } finally { this.loading = false }
    }
  }
})
