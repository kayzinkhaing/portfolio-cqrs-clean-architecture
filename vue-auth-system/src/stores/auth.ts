// src/stores/auth.ts
import { defineStore } from 'pinia'
import {
  login,
  logout,
  getProfile,
  register,
  updateProfile,
  enable2FA,
  verify2FA,
} from '@/services/auth'
import { setAuthToken } from '@/services/axios'
import type { User } from '@/services/types'

export interface Credentials {
  email: string
  password: string
}

interface AuthState {
  user: User | null
  token: string
  loading: boolean
  error: string | null
  initialized: boolean
  errors: Record<string, string>
  twoFactorVerified: boolean
  qrCode: string
}

export const useAuthStore = defineStore('auth', {
  state: (): AuthState => ({
    user: null,
    token: localStorage.getItem('token') || '',
    loading: false,
    error: null,
    initialized: false,
    errors: {},
    twoFactorVerified: false,
    qrCode: '',
  }),

  getters: {
    isAuthenticated: (state): boolean =>
      Boolean(state.token && state.user),
    requires2FA: (state): boolean =>
      Boolean(state.user?.two_factor_enabled && !state.twoFactorVerified),
  },

  actions: {
    setToken(token: string) {
      this.token = token
      localStorage.setItem('token', token)
      setAuthToken(token)
    },

    setUser(user: User) {
      this.user = user
    },

    setTwoFactorVerified(value: boolean) {
      this.twoFactorVerified = value
    },

    setQrCode(qr: string) {
      this.qrCode = qr
    },

    clearAuth() {
      this.user = null
      this.token = ''
      this.twoFactorVerified = false
      this.qrCode = ''
      localStorage.removeItem('token')
      setAuthToken(null)
    },

    async initialize() {
      // Special case: password reset pages don’t need auth state
      if (window.location.pathname.startsWith('/reset-password')) {
        this.initialized = true
        this.clearAuth()
        return
      }

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
    await this.fetchUser() // fetch user info
    return res // <-- return the login API response
  } catch (err: any) {
    this.error = err.response?.data?.message || 'Login failed'
    this.clearAuth()
    throw err
  } finally {
    this.loading = false
  }
},

    async verify2FACode(code: string) {
      if (!this.user) throw new Error('User not loaded')
      try {
        const res = await verify2FA(code)
        if (res.data.success) {
          this.setTwoFactorVerified(true)
        }
        return res.data
      } catch (err: any) {
        throw err
      }
    },

    async fetchUser() {
      if (!this.token) {
        this.clearAuth()
        this.initialized = true
        return
      }
      try {
        const res = await getProfile()
        // console.log('getProfile response:', res.data)
        this.user = res.data.data.user
        // console.log('User set in store:', this.user)
      } catch (err) {
        this.clearAuth()
      } finally {
        this.initialized = true
      }
    },

    async logoutUser() {
      try {
        await logout()
      } catch {
        // Ignore logout errors (token expired etc.)
      } finally {
        this.clearAuth()
      }
    },

    async updateUserProfile(updates: Partial<User>) {
      if (!this.user) return
      this.loading = true
      this.errors = {}
      try {
        const res = await updateProfile(updates)
        this.user = { ...this.user, ...res.data.data }
      } catch (err: any) {
        if (err.response?.status === 422) {
          this.errors = err.response.data.errors
        } else {
          throw err
        }
      } finally {
        this.loading = false
      }
    },
  },
})
