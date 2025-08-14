// src/services/axios.ts
import axios, { AxiosInstance, AxiosResponse } from 'axios'
import { ROUTES } from './routes'

export const api: AxiosInstance = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
  withCredentials: true,
})

// CSRF cookie helper
export const getCsrfCookie = (): Promise<AxiosResponse> =>
  axios.get(`${import.meta.env.VITE_API_URL || 'http://localhost:8000'}${ROUTES.csrf}`, {
    withCredentials: true,
  })

// Set or remove Authorization header
export const setAuthToken = (token: string | null) => {
  if (token) api.defaults.headers.common['Authorization'] = `Bearer ${token}`
  else delete api.defaults.headers.common['Authorization']
}

// Wrap state-changing requests with CSRF
export const withCsrf = async <T>(
  requestFn: () => Promise<AxiosResponse<T>>
): Promise<AxiosResponse<T>> => {
  await getCsrfCookie()
  return requestFn()
}
