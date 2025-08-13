// src/services/axiosSecure.ts
import axios from 'axios'

const axiosSecure = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  timeout: 5000,
  withCredentials: true, // Required for Sanctum cookie-based CSRF
  headers: {
    'Content-Type': 'application/json',
  }
})

// Response error handling
axiosSecure.interceptors.response.use(
  response => response,
  error => {
    if (error.response?.status === 401) {
      console.warn('Unauthorized — redirect to login if needed')
    }
    return Promise.reject(error)
  }
)

export default axiosSecure
