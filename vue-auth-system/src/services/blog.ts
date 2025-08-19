// src/services/blog.ts
import { api, withCsrf } from './axios'
import { ROUTES } from './routes'
import type { AxiosResponse } from 'axios'
import type { Blog, BlogData, BlogResponse } from '../api/types'

// Blog API methods
export const getBlogs = (params?: { page?: number; cursor?: string }): Promise<AxiosResponse<BlogResponse>> =>
  api.get(ROUTES.blogs.list, { params })

export const getBlog = (id: number | string): Promise<AxiosResponse<Blog>> =>
  api.get(ROUTES.blogs.item(id))

export const createBlog = (data: BlogData): Promise<AxiosResponse> =>
  withCsrf(() => api.post(ROUTES.blogs.list, data))

export const updateBlog = (id: number | string, data: BlogData): Promise<AxiosResponse<Blog>> =>
  withCsrf(() => api.put(ROUTES.blogs.item(id), data))

export const deleteBlog = (id: number | string): Promise<AxiosResponse> =>
  withCsrf(() => api.delete(ROUTES.blogs.item(id)))

export const getUserBlogs = (userId: number | string, params?: { page?: number; cursor?: string }): Promise<AxiosResponse<BlogResponse>> =>
  api.get(ROUTES.blogs.user(userId), { params })