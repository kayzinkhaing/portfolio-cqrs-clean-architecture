import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost:8000/api',
  withCredentials: true,
})

export const getCsrfCookie = () => axios.get('http://localhost:8000/sanctum/csrf-cookie', { withCredentials: true })

export const setAuthToken = (token) => {
  if (token) {
    api.defaults.headers.common['Authorization'] = `Bearer ${token}`
  } else {
    delete api.defaults.headers.common['Authorization']
  }
}

export const register = async (data) => {
  await getCsrfCookie()
  return api.post('/register', data)
}

export const login = async (data) => {
  await getCsrfCookie()
  return api.post('/login', data)
}

export const getProfile = () => api.get('/profile')
export const updateProfile = (data) => api.put('/update-profile', data)
export const logout = () => api.post('/logout')

export const getTownships = () => api.get('/townships')
export const getWards = () => api.get('/wards')
