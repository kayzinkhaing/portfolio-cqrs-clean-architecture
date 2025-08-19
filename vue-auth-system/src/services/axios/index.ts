import axios, { AxiosInstance } from 'axios';

export const api: AxiosInstance = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
  withCredentials: true,
});

export const getCsrfCookie = () => {
  const base = import.meta.env.VITE_API_BASE || 'http://localhost:8000';
  return axios.get(`${base}/sanctum/csrf-cookie`, { withCredentials: true });
};

export const withCsrf = async <T>(requestFn: () => Promise<any>): Promise<any> => {
  await getCsrfCookie();
  return requestFn();
};

export const setAuthToken = (token: string | null) => {
  if (token) api.defaults.headers.common['Authorization'] = `Bearer ${token}`;
  else delete api.defaults.headers.common['Authorization'];
};
