// src/services/location.ts
import { api } from './axios'
import { ROUTES } from './routes'
import type { AxiosResponse } from 'axios'

export const getTownships = (): Promise<AxiosResponse> => api.get(ROUTES.location.townships)
export const getWards = (): Promise<AxiosResponse> => api.get(ROUTES.location.wards)
