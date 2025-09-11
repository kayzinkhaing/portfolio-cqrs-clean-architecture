// src/stores/auth.ts
import { defineStore } from 'pinia'
import type { User, LoginData, RegisterData } from '../api/types'
import * as authCommand from '../api/commands/authCommand'
import * as authQuery from '../api/queries/authQuery'
import { setAuthToken } from '../api/axios'

interface AuthState {
  user: User | null
  accessToken: string | null
  isAuthenticated: boolean
  profileLoading: boolean
  loginLoading: boolean
  registerLoading: boolean
  error: string | null
  initialized: boolean
  requires2FA: boolean
}

export const useAuthStore = defineStore('auth', {
  state: (): AuthState => ({
    user: null,
    accessToken: null,
    isAuthenticated: false,
    profileLoading: false,
    loginLoading: false,
    registerLoading: false,
    error: null,
    initialized: false,
    requires2FA: false,
  }),

  actions: {
    // -------------------------
    // Utility
    // -------------------------
    setError(message: string) {
      this.error = message
    },
    clearError() {
      this.error = null
    },

    setAuthData({ user, access_token }: { user: User; access_token: string }) {
      this.user = user
      this.accessToken = access_token
      this.isAuthenticated = true
      this.requires2FA = user.two_factor_enabled || false
      setAuthToken(access_token) // ✅ set global axios header
    },

    clearAuthData() {
      this.user = null
      this.accessToken = null
      this.isAuthenticated = false
      this.requires2FA = false
      setAuthToken(null) // ✅ remove global header
    },

    // -------------------------
    // Register
    // -------------------------
    async register(data: RegisterData) {
      this.registerLoading = true
      this.clearError()
      try {
        const response = await authCommand.registerUser(data)
        if (response?.data) {
          this.setAuthData({
            user: response.data.user,
            access_token: response.data.access_token,
          })
        } else {
          this.setError(response?.message || 'Registration failed')
        }
      } catch (err) {
        console.error(err)
        this.setError('Registration error')
      } finally {
        this.registerLoading = false
      }
    },

    // -------------------------
    // Login
    // -------------------------
    async login(data: LoginData) {
      this.loginLoading = true
      this.clearError()
      try {
        const response = await authCommand.loginUser(data)
        if (response?.data) {
          this.setAuthData({
            user: response.data.user,
            access_token: response.data.access_token,
          })
        } else {
          this.setError(response?.message || 'Login failed')
        }
      } catch (err) {
        console.error(err)
        this.setError('Login error')
      } finally {
        this.loginLoading = false
      }
    },

    // -------------------------
    // Logout
    // -------------------------
    async logout() {
      try {
        await authCommand.logoutUser()
      } catch (err) {
        console.error(err)
      } finally {
        this.clearAuthData()
        this.initialized = false
      }
    },

    // -------------------------
    // Fetch Profile
    // -------------------------
    async fetchProfile() {
      this.profileLoading = true
      this.clearError()
      try {
        const user = await authQuery.getProfileUser()
        if (user) {
          this.user = user
          this.isAuthenticated = true
          this.requires2FA = user.two_factor_enabled || false
        } else {
          this.setError('Failed to fetch profile')
        }
      } catch (err) {
        console.error('Error in fetchProfile:', err)
        this.setError('Failed to fetch profile')
      } finally {
        this.profileLoading = false
      }
    },

    // -------------------------
    // Initialize (Refresh flow)
    // -------------------------
    async initialize() {
      if (this.initialized) return

      try {
        const response = await authCommand.refreshToken()
        if (response?.data?.access_token) {
          this.setAuthData({
            user: response.data.user,
            access_token: response.data.access_token,
          })
        }
      } catch (err) {
        console.error('Auth init failed:', err)
        this.clearAuthData()
      } finally {
        this.initialized = true
      }
    },
  },
})
