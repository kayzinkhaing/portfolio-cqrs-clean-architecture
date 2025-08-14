// src/services/axiosSecure.ts
import axios from 'axios'

const axiosSecure = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  timeout: 5000,
  withCredentials: true,
  headers: { 'Content-Type': 'application/json' },
})

axiosSecure.interceptors.response.use(
  response => response,
  error => {
    if (error.response?.status === 401) {
      console.warn('Unauthorized — maybe redirect to login')
    }
    return Promise.reject(error)
  }
)

export default axiosSecure
