import axios, { AxiosResponse } from 'axios'

const api = axios.create({
  baseURL: 'http://localhost:8000/api',
  withCredentials: true,
})

// Define data types (customize as needed)
interface RegisterData {
  name: string
  email: string
  password: string
  password_confirmation: string
}

interface LoginData {
  email: string
  password: string
}

interface ProfileData {
  name?: string
  email?: string
}

interface BlogData {
  title: string
  excerpt: string
  content: string
}

// CSRF and auth token helpers
export const getCsrfCookie = (): Promise<AxiosResponse> =>
  axios.get('http://localhost:8000/sanctum/csrf-cookie', { withCredentials: true })

export const setAuthToken = (token: string | null): void => {
  if (token) {
    api.defaults.headers.common['Authorization'] = `Bearer ${token}`
  } else {
    delete api.defaults.headers.common['Authorization']
  }
}

// Auth
export const register = async (data: RegisterData): Promise<AxiosResponse> => {
  await getCsrfCookie()
  return api.post('/register', data)
}

export const login = async (data: LoginData): Promise<AxiosResponse> => {
  await getCsrfCookie()
  return api.post('/login', data)
}

export const getProfile = (): Promise<AxiosResponse> => api.get('/profile')

export const updateProfile = (data: ProfileData): Promise<AxiosResponse> =>
  api.put('/update-profile', data)

export const logout = (): Promise<AxiosResponse> => api.post('/logout')

// Location data
export const getTownships = (): Promise<AxiosResponse> => api.get('/townships')

export const getWards = (): Promise<AxiosResponse> => api.get('/wards')

// Blogs — Public (no auth required)
// export const getBlogs = (): Promise<AxiosResponse> => api.get('/blogs')
export const getBlogs = (page = 1): Promise<AxiosResponse> =>
    api.get(`/blogs?page=${page}`)



export const getBlog = (id: number | string): Promise<AxiosResponse> =>
  api.get(`/blogs/${id}`)

// Blogs — Protected (auth required)
export const createBlog = async (data: BlogData): Promise<AxiosResponse> => {
  await getCsrfCookie()
  return api.post('/blogs', data)
}

export const updateBlog = async (
  id: number | string,
  data: BlogData
): Promise<AxiosResponse> => {
  await getCsrfCookie()
  return api.put(`/blogs/${id}`, data)
}

export const deleteBlog = async (id: number | string): Promise<AxiosResponse> => {
  await getCsrfCookie()
  return api.delete(`/blogs/${id}`)
}
