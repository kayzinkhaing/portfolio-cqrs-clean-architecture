// src/services/auth.ts
import { api, withCsrf } from './axios'
import { ROUTES } from './routes'
import type { RegisterData, LoginData, AuthResponse, User } from './types'
import type { AxiosResponse } from 'axios'

// Auth API methods
export const register = (data: RegisterData): Promise<AxiosResponse<{ data: AuthResponse }>> =>
  withCsrf(() => api.post(ROUTES.auth.register, data))

export const login = (data: LoginData): Promise<AxiosResponse<{ data: AuthResponse }>> =>
  withCsrf(() => api.post(ROUTES.auth.login, data))

export const getProfile = (): Promise<AxiosResponse<User>> => api.get(ROUTES.auth.profile)

export const updateProfile = (
  data: Partial<User>
): Promise<AxiosResponse<{ data: User }>> => withCsrf(() => api.put(ROUTES.auth.updateProfile, data))

export const logout = (): Promise<AxiosResponse> => withCsrf(() => api.post(ROUTES.auth.logout))

// --- New Forgot & Reset Password API methods ---
export const forgotPassword = (email: string): Promise<AxiosResponse<{ success: boolean; message: string }>> =>
  withCsrf(() => api.post(ROUTES.auth.forgotPassword, { email }))

export const resetPassword = (payload: {
  email: string
  token: string
  password: string
  password_confirmation: string
}): Promise<AxiosResponse<{ success: boolean; message: string }>> =>
  withCsrf(() => api.post(ROUTES.auth.resetPassword, payload))

  // --- New 2FA API methods ---
export const enable2FA = (): Promise<AxiosResponse<{ success: boolean; qr: string; secret: string }>> =>
  withCsrf(() => api.post(ROUTES.auth.enable2FA))

// --- Disable 2FA API method ---
export const disable2FA = (): Promise<AxiosResponse<{ success: boolean; message: string; data: User }>> =>
  withCsrf(() => api.post(ROUTES.auth.disable2FA))


export const verify2FA = (code: string): Promise<AxiosResponse<{ success: boolean; message: string }>> =>
  withCsrf(() => api.post(ROUTES.auth.verify2FA, { code }))
