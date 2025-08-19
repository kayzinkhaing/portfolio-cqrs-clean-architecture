import { api, withCsrf } from './index';
import type { BlogData, BlogResponse, Blog } from './types/blog';


export const createBlog = (data: BlogData) =>
  withCsrf(() => api.post('/blogs', data));

export const updateBlog = (id: number | string, data: BlogData) =>
  withCsrf(() => api.put(`/blogs/${id}`, data));

export const deleteBlog = (id: number | string) =>
  withCsrf(() => api.delete(`/blogs/${id}`));
