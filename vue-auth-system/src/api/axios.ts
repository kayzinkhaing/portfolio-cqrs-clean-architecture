// src/api/axios.ts
import axios, { AxiosInstance, AxiosResponse } from 'axios'
import { ROUTES } from './routes'

// -------------------------
// Public API (no cookies)
// -------------------------
export const publicApi = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
  withCredentials: false,
})

// -------------------------
// Authenticated API (cookies + bearer token)
// -------------------------
export const commandApi = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
  withCredentials: true, // ✅ cookies included
})

// -------------------------
// Query API (optional GraphQL)
// -------------------------
export const queryApi: AxiosInstance = axios.create({
  baseURL: import.meta.env.VITE_GRAPHQL_URL || 'http://localhost:8000/graphql',
  withCredentials: true,
})

// -------------------------
// CSRF helper
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
