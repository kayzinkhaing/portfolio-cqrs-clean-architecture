//C:\xampp\htdocs\vue-testing-project\vue-auth-system\src\services\auth.ts
import { api, withCsrf } from './axios'
import { ROUTES } from './routes'
import type { RegisterData, LoginData, AuthResponse, User } from './types'
import type { AxiosResponse } from 'axios'

// ------------------ AUTH ------------------

// Register
export const register = (
  data: RegisterData
): Promise<AxiosResponse<AuthResponse>> =>
  withCsrf(() => api.post(ROUTES.auth.register, data))

// Login
export const login = (
  data: LoginData
): Promise<AxiosResponse<AuthResponse>> =>
  withCsrf(() => api.post(ROUTES.auth.login, data))

// Logout
export const logout = (): Promise<AxiosResponse> =>
  withCsrf(() => api.post(ROUTES.auth.logout))

// Get current user profile
export const getProfile = (): Promise<
  AxiosResponse<{ data: { user: User } }>
> => withCsrf(() => api.get(ROUTES.auth.profile))


// Update profile
export const updateProfile = (
  data: Partial<User>
): Promise<AxiosResponse<{ data: User }>> =>
  withCsrf(() => api.put(ROUTES.auth.updateProfile, data))

// ------------------ PASSWORD RESET ------------------

export const forgotPassword = (
  email: string
): Promise<AxiosResponse<{ success: boolean; message: string }>> =>
  withCsrf(() => api.post(ROUTES.auth.forgotPassword, { email }))

export const resetPassword = (payload: {
  email: string
  token: string
  password: string
  password_confirmation: string
}): Promise<AxiosResponse<{ success: boolean; message: string }>> =>
  withCsrf(() => api.post(ROUTES.auth.resetPassword, payload))

// ------------------ TWO FACTOR AUTH ------------------

export const enable2FA = (): Promise<
  AxiosResponse<{ success: boolean; qr: string; secret: string }>
> => withCsrf(() => api.post(ROUTES.auth.enable2FA))

export const disable2FA = (): Promise<
  AxiosResponse<{ success: boolean; message: string; data: User }>
> => withCsrf(() => api.post(ROUTES.auth.disable2FA))

export const verify2FA = (
  code: string
): Promise<AxiosResponse<{ success: boolean; message: string }>> =>
  withCsrf(() => api.post(ROUTES.auth.verify2FA, { code }))
