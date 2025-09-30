// src/api/axios.ts
import axios, { AxiosInstance, AxiosResponse } from 'axios'
import { ROUTES } from './routes'

// Public API (no cookies)
export const publicApi = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:80/api',
  withCredentials: false,
})

// Authenticated API (cookies + bearer token)
export const commandApi = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
  withCredentials: true,
})

// GraphQL API
export const queryApi: AxiosInstance = axios.create({
  baseURL: import.meta.env.VITE_GRAPHQL_URL || 'http://localhost:80/graphql',
  withCredentials: true,
})

// CSRF helper
export const getCsrfCookie = (): Promise<AxiosResponse> => {
  const base = import.meta.env.VITE_API_BASE || 'http://localhost'
  return axios.get(`${base}${ROUTES.csrf}`, { withCredentials: true })
}

// Wrap commands with CSRF and return typed data
export const withCsrf = async <T>(
  requestFn: () => Promise<AxiosResponse<T>>
): Promise<T> => {
  await getCsrfCookie()
  const res = await requestFn()
  return res.data // ✅ return the data directly
}

// Set Auth Token Globally
export const setAuthToken = (token: string | null) => {
  const authHeader = token ? `Bearer ${token}` : undefined
  commandApi.defaults.headers.common['Authorization'] = authHeader
  queryApi.defaults.headers.common['Authorization'] = authHeader
}
