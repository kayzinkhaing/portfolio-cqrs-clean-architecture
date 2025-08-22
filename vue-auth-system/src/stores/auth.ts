import { defineStore } from 'pinia'
import type { User, LoginData, RegisterData } from '../api/types'
import * as authCommand from '../api/commands/authCommand'
import * as authQuery from '../api/queries/authQuery'

interface AuthState {
  user: User | null
  token: string | null
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
    token: localStorage.getItem('token') || null,
    isAuthenticated: !!localStorage.getItem('token'),
    profileLoading: false,
    loginLoading: false,
    registerLoading: false,
    error: null,
    initialized: false,
    requires2FA: false,
  }),

  actions: {
    // -------------------------
    // Utility methods
    // -------------------------
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
      this.requires2FA = user.two_factor_enabled || false
      localStorage.setItem('token', token)
    },
    clearAuthData() {
      this.user = null
      this.token = null
      this.isAuthenticated = false
      this.requires2FA = false
      localStorage.removeItem('token')
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
          this.setAuthData(response.data)
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
          this.setAuthData(response.data)
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
    console.log('Fetched user:', user) // <-- debug here
    if (user) {
      this.user = user
      this.isAuthenticated = true
      this.requires2FA = user.two_factor_enabled || false
    } else {
      this.setError('Failed to fetch profile')
    }
  } catch (err) {
    console.error('Error in fetchProfile:', err) // <-- debug here
    this.setError('Failed to fetch profile')
  } finally {
    this.profileLoading = false
  }
}
,

    // -------------------------
    // Initialize Auth
    // -------------------------
    async initialize() {
      if (this.token && !this.initialized) {
        await this.fetchProfile()
        this.initialized = true
      }
    },
  },
})
