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
