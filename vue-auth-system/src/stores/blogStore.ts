// src/stores/blogStore.ts
import { defineStore } from 'pinia'
import type { Blog, BlogData } from '../api/types'
import * as blogCommand from '../api/commands/blogCommand'
import * as blogQuery from '../api/queries/blogQuery'

interface BlogState {
  blogs: Blog[]
  loading: boolean
  error: string | null
}

export const useBlogStore = defineStore('blog', {
  state: (): BlogState => ({
    blogs: [],
    loading: false,
    error: null,
  }),

  actions: {
    // -------------------------
    // Fetch all blogs (Read)
    // -------------------------
    async fetchBlogs() {
      this.loading = true
      this.error = null
      try {
        const response = await blogQuery.fetchBlogs()
        this.blogs = response || []
      } catch (err: any) {
        this.error = err.message || 'Failed to fetch blogs'
      } finally {
        this.loading = false
      }
    },

    // -------------------------
    // Create new blog (Write)
    // -------------------------
    async createBlog(data: BlogData) {
      this.loading = true
      this.error = null
      try {
        const newBlog = await blogCommand.createBlog(data)
        if (newBlog) {
          this.blogs.unshift(newBlog) // add to the top
        }
      } catch (err: any) {
        this.error = err.message || 'Failed to create blog'
      } finally {
        this.loading = false
      }
    },

    // -------------------------
    // Update blog (Write)
    // -------------------------
    async updateBlog(id: number | string, data: BlogData) {
      this.loading = true
      this.error = null
      try {
        const updatedBlog = await blogCommand.updateBlog(id, data)
        if (updatedBlog) {
          const index = this.blogs.findIndex(blog => blog.id === id)
          if (index !== -1) {
            this.blogs[index] = updatedBlog
          }
        }
      } catch (err: any) {
        this.error = err.message || 'Failed to update blog'
      } finally {
        this.loading = false
      }
    },

    // -------------------------
    // Delete blog (Write)
    // -------------------------
    async deleteBlog(id: number | string) {
      this.loading = true
      this.error = null
      try {
        await blogCommand.deleteBlog(id)
        this.blogs = this.blogs.filter(blog => blog.id !== id)
      } catch (err: any) {
        this.error = err.message || 'Failed to delete blog'
      } finally {
        this.loading = false
      }
    },
  },
})
