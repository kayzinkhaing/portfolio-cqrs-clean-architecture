// src/stores/auth.ts
import { defineStore } from 'pinia'
import { login, logout, getProfile, register, updateProfile, enable2FA, verify2FA } from '@/services/auth'
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
    errors: {} as Record<string, string>,
    twoFactorVerified: false, // NEW: track 2FA verification
    qrCode: '' as string,     // NEW: store QR code if needed
  }),
  getters: {
    isAuthenticated: state => !!state.token && !!state.user,
    requires2FA: state => !!state.user?.two_factor_enabled && !state.twoFactorVerified
  },
  actions: {
    setToken(token: string) {
      this.token = token
      localStorage.setItem('token', token)
      setAuthToken(token)
    },
    setUser(user: User) { this.user = user },
    setTwoFactorVerified(value: boolean) { this.twoFactorVerified = value },
    setQrCode(qr: string) { this.qrCode = qr },
    clearAuth() {
      this.user = null
      this.token = ''
      this.twoFactorVerified = false
      this.qrCode = ''
      localStorage.removeItem('token')
      setAuthToken(null)
    },
    async initialize() {
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
        await this.fetchUser()

        // If user has 2FA enabled, fetch QR code for first-time setup
        if (this.user?.two_factor_enabled) {
          const qrRes = await enable2FA()
          this.setQrCode(qrRes.data.qr)
        }

      } catch (err: any) {
        this.error = err.response?.data?.message || 'Login failed'
        this.clearAuth()
        throw err
      } finally { this.loading = false }
    },
    async verify2FACode(code: string) {
      if (!this.user) throw new Error('User not loaded')
      try {
        const res = await verify2FA(code)
        if (res.data.success) this.setTwoFactorVerified(true)
        return res.data
      } catch (err: any) {
        throw err
      }
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
