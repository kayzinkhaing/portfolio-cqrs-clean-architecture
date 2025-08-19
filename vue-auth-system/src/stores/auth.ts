// src/stores/auth.ts
import { defineStore } from 'pinia'
import type { User, LoginData, RegisterData, AuthResponse } from '../api/types'
import * as authCommand from '../api/commands/authCommand'
import * as authQuery from '../api/queries/authQuery'

interface AuthState {
  user: User | null
  token: string | null
  isAuthenticated: boolean
  loading: boolean
  error: string | null
}

export const useAuthStore = defineStore('auth', {
  state: (): AuthState => ({
    user: null,
    token: localStorage.getItem('token') || null,
    isAuthenticated: !!localStorage.getItem('token'),
    loading: false,
    error: null,
  }),

  actions: {
    setLoading(value: boolean) {
      this.loading = value
    },
    setError(message: string) {
      this.error = message
    },
    clearError() {
      this.error = null
    },
    setAuthData({ user, token }: { user: User; token: string }) {
      this.user = user
      this.token = token
      this.isAuthenticated = true
      localStorage.setItem('token', token)
    },

    // -------------------------
    // Register
    // -------------------------
    async register(data: RegisterData) {
      this.setLoading(true)
      this.clearError()

      const response = await authCommand.registerUser(data)
      if (response?.data) this.setAuthData(response.data)
      else this.setError(response?.message || 'Registration failed')

      this.setLoading(false)
    },

    // -------------------------
    // Login
    // -------------------------
    async login(data: LoginData) {
      this.setLoading(true)
      this.clearError()

      const response = await authCommand.loginUser(data)
      if (response?.data) this.setAuthData(response.data)
      else this.setError(response?.message || 'Login failed')

      this.setLoading(false)
    },

    // -------------------------
    // Logout
    // -------------------------
    async logout() {
      this.setLoading(true)
      try {
        await authCommand.logoutUser()
      } catch (err) {
        console.error(err)
      } finally {
        this.user = null
        this.token = null
        this.isAuthenticated = false
        localStorage.removeItem('token')
        this.setLoading(false)
      }
    },

    // -------------------------
    // Fetch Profile (Query)
    // -------------------------
    async fetchProfile() {
      this.setLoading(true)
      this.clearError()

      const user = await authQuery.getProfileUser()
      if (user) this.user = user
      else this.setError('Failed to fetch profile')

      this.setLoading(false)
    },

    // -------------------------
    // Initialize Auth
    // -------------------------
    async initialize() {
      if (this.token) await this.fetchProfile()
    },
  },
})
