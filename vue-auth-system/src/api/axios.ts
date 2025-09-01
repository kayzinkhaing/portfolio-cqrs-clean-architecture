// src/api/axios.ts
import axios, { AxiosInstance, AxiosResponse } from 'axios'
import { ROUTES } from './routes'

// -------------------------
// Command API (Write) - Laravel
// -------------------------
// ✅ Public API (no CSRF, no credentials)
export const publicApi = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
  withCredentials: false, // ❌ no cookies, no CSRF
})

// ✅ Authenticated API (requires CSRF and cookies)
export const commandApi = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
  withCredentials: true, // ✅ include cookies for auth
})

// -------------------------
// Query API (Read) - REST fallback (optional)
// -------------------------
export const queryApi: AxiosInstance = axios.create({
  baseURL: import.meta.env.VITE_GRAPHQL_URL || 'http://localhost:8000/graphql',
  withCredentials: true,
})

// -------------------------
// CSRF for commands
// -------------------------
export const getCsrfCookie = (): Promise<AxiosResponse> => {
  const base = import.meta.env.VITE_API_BASE || 'http://localhost:8000'
  return axios.get(`${base}${ROUTES.csrf}`, { withCredentials: true })
}

// -------------------------
// Set Auth Token Globally
// -------------------------
export const setAuthToken = (token: string | null) => {
  const authHeader = token ? `Bearer ${token}` : undefined

  commandApi.defaults.headers.common['Authorization'] = authHeader
  queryApi.defaults.headers.common['Authorization'] = authHeader
}

// -------------------------
// Wrap Command Requests with CSRF
// -------------------------
export const withCsrf = async <T>(
  requestFn: () => Promise<AxiosResponse<T>>
): Promise<AxiosResponse<T>> => {
  await getCsrfCookie()
  return requestFn()
}
