// src/api/commands/authCommand.ts
import type { RegisterData, LoginData, AuthResponse } from '../types'
import { commandApi, withCsrf } from '../axios'
import { ROUTES } from '../routes'

// -------------------------
// Generic wrapper for commands
// -------------------------
async function executeCommand<T>(fn: () => Promise<T>): Promise<T | null> {
  try {
    return await fn()
  } catch (error) {
    console.error('Command failed:', error)
    return null
  }
}

// -------------------------
// Register a new user
// -------------------------
export const registerUser = (data: RegisterData): Promise<AuthResponse | null> =>
  executeCommand(() =>
    withCsrf(() => commandApi.post<AuthResponse>(ROUTES.auth.register, data)).then(res => res.data)
  )

// -------------------------
// Login user
// -------------------------
export const loginUser = (data: LoginData): Promise<AuthResponse | null> =>
  executeCommand(() =>
    withCsrf(() => commandApi.post<AuthResponse>(ROUTES.auth.login, data)).then(res => res.data)
  )

// -------------------------
// Logout user
// -------------------------
export const logoutUser = (): Promise<boolean> =>
  executeCommand(() =>
    withCsrf(() => commandApi.post(ROUTES.auth.logout)).then(() => true)
  ).then(res => !!res)

// -------------------------
// Update user profile
// -------------------------
export const updateProfile = (data: Partial<RegisterData>): Promise<AuthResponse | null> =>
  executeCommand(() =>
    withCsrf(() => commandApi.put<AuthResponse>(ROUTES.auth.updateProfile, data)).then(res => res.data)
  )

// -------------------------
// Two-Factor Authentication
// -------------------------
export const enable2FA = (): Promise<AuthResponse | null> =>
  executeCommand(() =>
    withCsrf(() => commandApi.post<AuthResponse>(ROUTES.auth.enable2FA)).then(res => res.data)
  )

export const disable2FA = (): Promise<AuthResponse | null> =>
  executeCommand(() =>
    withCsrf(() => commandApi.post<AuthResponse>(ROUTES.auth.disable2FA)).then(res => res.data)
  )

export const verify2FA = (code: string): Promise<AuthResponse | null> =>
  executeCommand(() =>
    withCsrf(() => commandApi.post<AuthResponse>(ROUTES.auth.verify2FA, { code })).then(res => res.data)
  )
