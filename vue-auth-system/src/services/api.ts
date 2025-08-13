// src/services/api.ts
import axios, { AxiosInstance, AxiosResponse } from 'axios'

// Axios instance with baseURL and credentials for CSRF cookies & sessions
const api: AxiosInstance = axios.create({
  baseURL: 'http://localhost:8000/api',
  withCredentials: true,
})

// --- Types ---

// User returned by backend
export interface User {
  id: number
  name: string
  email: string
  township_id?: number
  ward_id?: number
  created_at?: string
  updated_at?: string
}

export interface RegisterData {
  name: string
  email: string
  password: string
  password_confirmation: string
}

export interface LoginData {
  email: string
  password: string
}

export interface BlogData {
  title: string
  excerpt: string
  content: string
}

// Response shape for Auth endpoints (login/register)
export interface AuthResponse {
  user: User
  token: string
  token_type: string
}

// --- CSRF Token Management ---

/**
 * Fetch CSRF cookie from backend. Call before state-changing requests.
 */
export const getCsrfCookie = (): Promise<AxiosResponse> =>
  axios.get('http://localhost:8000/sanctum/csrf-cookie', { withCredentials: true })

// --- Auth Token Management ---

/**
 * Set or clear the Authorization header for all axios requests
 * @param token - Bearer token or null to clear
 */
export const setAuthToken = (token: string | null): void => {
  if (token) {
    api.defaults.headers.common['Authorization'] = `Bearer ${token}`
  } else {
    delete api.defaults.headers.common['Authorization']
  }
}

// --- Helper for CSRF protected requests ---

async function withCsrf<T>(
  requestFn: () => Promise<AxiosResponse<T>>
): Promise<AxiosResponse<T>> {
  await getCsrfCookie()
  return requestFn()
}

// --- API Methods ---

// Register new user
export const register = (data: RegisterData): Promise<AxiosResponse<{ data: AuthResponse }>> =>
  withCsrf(() => api.post('/register', data))

// Login user
export const login = (data: LoginData): Promise<AxiosResponse<{ data: AuthResponse }>> =>
  withCsrf(() => api.post('/login', data))

// Get currently authenticated user's profile
export const getProfile = (): Promise<AxiosResponse<User>> =>
  api.get('/profile')

// Update user's profile
export const updateProfile = (data: Partial<User>): Promise<AxiosResponse<{ data: User }>> =>
  withCsrf(() => api.put('/update-profile', data))

// Logout user
export const logout = (): Promise<AxiosResponse> =>
  withCsrf(() => api.post('/logout'))

// --- Location data ---

export const getTownships = (): Promise<AxiosResponse> =>
  api.get('/townships')

export const getWards = (): Promise<AxiosResponse> =>
  api.get('/wards')

// --- Blog endpoints ---

export const getBlogs = (params?: { page?: number; cursor?: string }): Promise<AxiosResponse> =>
  api.get('/blogs', { params })

export const getBlog = (id: number | string): Promise<AxiosResponse> =>
  api.get(`/blogs/${id}`)

export const createBlog = (data: BlogData): Promise<AxiosResponse> =>
  withCsrf(() => api.post('/blogs', data))

export const updateBlog = (id: number | string, data: BlogData): Promise<AxiosResponse> =>
  withCsrf(() => api.put(`/blogs/${id}`, data))

export const deleteBlog = (id: number | string): Promise<AxiosResponse> =>
  withCsrf(() => api.delete(`/blogs/${id}`))
