// src/api/commands/blogCommand.ts
import type { BlogData, Blog } from '../types'
import { commandApi, withCsrf } from '../axios'
import { ROUTES } from '../routes'

// -------------------------
// Create a new blog
// -------------------------
export const createBlog = async (data: BlogData): Promise<Blog | null> => {
  try {
    const response = await withCsrf(() => commandApi.post<Blog>(ROUTES.blogs.list, data))
    return response.data
  } catch (error) {
    console.error('Error creating blog:', error)
    return null
  }
}

// -------------------------
// Update an existing blog
// -------------------------
export const updateBlog = async (id: number | string, data: BlogData): Promise<Blog | null> => {
  try {
    const response = await withCsrf(() => commandApi.put<Blog>(ROUTES.blogs.item(id), data))
    return response.data
  } catch (error) {
    console.error(`Error updating blog ${id}:`, error)
    return null
  }
}

// -------------------------
// Delete a blog
// -------------------------
export const deleteBlog = async (id: number | string): Promise<boolean> => {
  try {
    await withCsrf(() => commandApi.delete(ROUTES.blogs.item(id)))
    return true
  } catch (error) {
    console.error(`Error deleting blog ${id}:`, error)
    return false
  }
}

// -------------------------
// Optional: assign blog to a user
// -------------------------
export const assignBlogToUser = async (
  blogId: number | string,
  userId: number | string
): Promise<Blog | null> => {
  try {
    const response = await withCsrf(() =>
      commandApi.post(`/blogs/${blogId}/assign-user`, { user_id: userId })
    )
    return response.data
  } catch (error) {
    console.error(`Error assigning blog ${blogId} to user ${userId}:`, error)
    return null
  }
}
