import { defineStore } from 'pinia'
import { login, logout, getProfile, register, setAuthToken } from '@/services/api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || '',
    loading: false,
    error: null,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token && !!state.user,
  },

  actions: {
    setToken(token) {
      this.token = token
      localStorage.setItem('token', token)
      setAuthToken(token)
    },
    setUser(user) {
    this.user = user
  },

    clearAuth() {
      this.user = null
      this.token = ''
      localStorage.removeItem('token')
      setAuthToken(null)
    },

    async loginUser(credentials) {
      this.loading = true
      this.error = null
      try {
        const res = await login(credentials)
        this.setToken(res.data.data.token)
        await this.fetchUser()
      } catch (err) {
        this.error = err.response?.data?.message || 'Login failed'
        this.clearAuth()
      } finally {
        this.loading = false
      }
    },

    async fetchUser() {
      if (!this.token) {
        this.clearAuth()
        return
      }
      try {
        const res = await getProfile()
        this.user = res.data
      } catch {
        this.clearAuth()
      }
    },

    async logoutUser() {
      try {
        await logout()
      } catch (err) {
        console.error('Logout failed', err)
      }
      this.clearAuth()
    },
  },
})
