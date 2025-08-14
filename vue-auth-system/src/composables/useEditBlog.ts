// src/composables/useEditBlog.ts
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useErrorStore } from '@/stores/errorStore'
import { useBlogStore } from '@/stores/blogStore'
import { blogFields } from '@/config/forms/blogFields'
import { validateBlogForm } from '@/utils/blogValidation'
import { useQueryClient } from '@tanstack/vue-query'

export interface BlogForm {
  title: string
  excerpt: string
  content: string
  published_at?: string
}

export function useEditBlog() {
  const route = useRoute()
  const router = useRouter()
  const auth = useAuthStore()
  const errorStore = useErrorStore()
  const blogStore = useBlogStore()
  const queryClient = useQueryClient()

  // Reactive form state
  const form = ref<BlogForm>({
    title: '',
    excerpt: '',
    content: '',
    published_at: '',
  })

  // Computed dynamic fields configuration
  const fields = computed(() => blogFields())

  // Loading state for fetch and update operations
  const isLoading = ref(false)

  /**
   * Fetch blog data by ID for editing
   */
  const fetchBlog = async () => {
    errorStore.clearErrors()

    const id = Number(route.params.id)
    if (!id) {
      errorStore.setGeneralError('Invalid blog ID.')
      return
    }

    // Attempt to find blog in store first
    let blog = blogStore.blogs.find(b => b.id === id)

    // If not found, fetch from API/store
    if (!blog) {
      const fetchedBlog = await blogStore.fetchBlogById(id)
      if (!fetchedBlog) return // errorStore already set in fetchBlogById
      blog = fetchedBlog
    }

    // Authorization check: only blog owner can edit
    if (auth.user?.id !== blog.user_id) {
      errorStore.setGeneralError('Not authorized to edit this blog.')
      return
    }

    // Populate form with blog data
    form.value = {
      title: blog.title,
      excerpt: blog.excerpt || '',
      content: blog.content,
      published_at: blog.published_at?.slice(0, 16) || '',
    }
  }

  /**
   * Validate and update the blog post
   */
  const handleUpdate = async () => {
    errorStore.clearErrors()

    // Validate form fields
    const validationErrors = validateBlogForm(form.value)
    if (Object.keys(validationErrors).length > 0) {
      const errorsForStore: Record<string, string[]> = {}
      for (const key in validationErrors) {
        errorsForStore[key] = [validationErrors[key]]
      }
      errorStore.setValidationErrors(errorsForStore)
      return
    }

    const id = Number(route.params.id)
    if (!id) {
      errorStore.setGeneralError('Invalid blog ID.')
      return
    }

    isLoading.value = true
    const success = await blogStore.updateBlogById(id, form.value)
    isLoading.value = false

    if (success) {
      // Invalidate the blogs query cache to trigger refetch and update blog list dynamically
      const queryClient = useQueryClient()

      await queryClient.invalidateQueries({ queryKey: ['blogs'] })


      // Navigate back to blog list view
      router.push('/blogs')
    }
  }

  return {
    form,
    fields,
    handleUpdate,
    isLoading,
    errorStore,
    fetchBlog,
  }
}
