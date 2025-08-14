import { getBlogs, getBlog, createBlog, updateBlog, deleteBlog } from '@/services/blog'
import type { Blog, BlogResponse } from '@/services/blog'
import type { BlogData } from '@/services/types'
import { defineStore } from 'pinia'
interface BlogState {
  blogs: Blog[]
  loading: boolean
  error: string | null
  nextPageUrl: string | null
}

export const useBlogStore = defineStore('blog', {
  state: (): BlogState => ({
    blogs: [],
    loading: false,
    error: null,
    nextPageUrl: null,
  }),

  actions: {
    async fetchBlogs(params?: { page?: number; cursor?: string }) {
      this.loading = true
      this.error = null
      try {
        const res = await getBlogs(params)
        this.blogs = res.data.data
        this.nextPageUrl = res.data.next_page_url
      } catch (err: any) {
        this.error = err.response?.data?.message || 'Failed to load blogs'
      } finally {
        this.loading = false
      }
    },

    async fetchBlogById(id: number | string): Promise<Blog | null> {
      this.loading = true
      this.error = null
      try {
        const res = await getBlog(id)
        const blog: Blog = res.data

        const index = this.blogs.findIndex(b => b.id === blog.id)
        if (index !== -1) this.blogs[index] = blog
        else this.blogs.push(blog)

        return blog
      } catch (err: any) {
        this.error = err.response?.data?.message || 'Failed to load blog'
        return null
      } finally {
        this.loading = false
      }
    },

    // ✅ Add this method
    async updateBlogById(id: number | string, data: Partial<BlogData>): Promise<boolean> {
      this.loading = true
      this.error = null
      try {
        const res = await updateBlog(id, data as BlogData)
        const updatedBlog: Blog = res.data

        const index = this.blogs.findIndex(b => b.id === updatedBlog.id)
        if (index !== -1) this.blogs[index] = updatedBlog
        else this.blogs.push(updatedBlog)

        return true
      } catch (err: any) {
        this.error = err.response?.data?.message || 'Failed to update blog'
        return false
      } finally {
        this.loading = false
      }
    },

    async addBlog(blogData: Partial<BlogData>) {
      try {
        const res = await createBlog(blogData as BlogData)
        this.blogs.unshift(res.data)
      } catch (err: any) {
        this.error = err.response?.data?.message || 'Failed to add blog'
      }
    },

    async removeBlog(blogId: number | string) {
      try {
        await deleteBlog(blogId)
        this.blogs = this.blogs.filter(blog => blog.id !== blogId)
      } catch (err: any) {
        this.error = err.response?.data?.message || 'Failed to delete blog'
      }
    }
  }
})
