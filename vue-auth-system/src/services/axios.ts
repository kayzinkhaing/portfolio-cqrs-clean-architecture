  import axios, { AxiosInstance, AxiosResponse } from 'axios'
  import { ROUTES } from './routes'

  // Base API instance
  export const api: AxiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
    withCredentials: true,
  })

  // Get CSRF cookie (needed for Sanctum)
  export const getCsrfCookie = (): Promise<AxiosResponse> => {
    const base = import.meta.env.VITE_API_URL || 'http://localhost:8000'
    return axios.get(`${base}${ROUTES.csrf}`, { withCredentials: true })
  }

  // Set or remove Authorization header globally
  export const setAuthToken = (token: string | null) => {
    if (token) {
      api.defaults.headers.common['Authorization'] = `Bearer ${token}`
    } else {
      delete api.defaults.headers.common['Authorization']
    }
  }

  // Wrap state-changing requests with CSRF protection
  export const withCsrf = async <T>(
    requestFn: () => Promise<AxiosResponse<T>>
  ): Promise<AxiosResponse<T>> => {
    await getCsrfCookie()
    return requestFn()
  }
