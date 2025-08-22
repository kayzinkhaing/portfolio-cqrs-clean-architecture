// src/composables/useBlogs.ts
import { ref, computed } from 'vue'
import { useInfiniteQuery, useMutation, useQueryClient, QueryFunctionContext } from '@tanstack/vue-query'
import type { InfiniteData } from '@tanstack/query-core'
import type { Blog, BlogData, BlogResponse } from '@/api/types'
import { useAuthStore } from '@/stores/auth'
import { useErrorStore } from '@/stores/errorStore'
import { useBlogStore } from '@/stores/blogStore'
import { handleApiError } from '@/utils/errorHandler'
import { useRouter } from 'vue-router'
import { parseISO, formatDistanceToNow, isValid } from 'date-fns'
export default function useBlogs() {
  const auth = useAuthStore()
  const errorStore = useErrorStore()
  const blogStore = useBlogStore()
  const queryClient = useQueryClient()
  const router = useRouter()

  const deletingBlogId = ref<number | string | null>(null)
  const currentUserId = computed(() => auth.user?.id)
  type QueryKey = ['blogs']

  // --- Time formatting ---
 const formatTimeAgo = (isoDateString?: string): string => {
  if (!isoDateString) return 'unknown'

  const parsedDate = parseISO(isoDateString)
  if (!isValid(parsedDate)) return 'unknown'

  return formatDistanceToNow(parsedDate, { addSuffix: true })
}

  // --- Infinite Query for Blogs ---
  const fetchBlogs = async (context: QueryFunctionContext<QueryKey, unknown>): Promise<BlogResponse> => {
    const cursor = context.pageParam ?? null
    await blogStore.fetchBlogs() // Fetch blogs via store
    const pageData: BlogResponse = {
      data: blogStore.blogs,
      next_page_url: null, // If you implement pagination in store, set this dynamically
    }
    return pageData
  }

  const {
    data,
    fetchNextPage,
    hasNextPage,
    isFetchingNextPage,
    status,
    error,
  } = useInfiniteQuery<BlogResponse, Error, InfiniteData<BlogResponse>, QueryKey>({
    queryKey: ['blogs'],
    queryFn: fetchBlogs,
    getNextPageParam: (lastPage) =>
      lastPage.next_page_url
        ? new URL(lastPage.next_page_url, window.location.origin).searchParams.get('cursor') || undefined
        : undefined,
    initialPageParam: null,
    staleTime: 0,
  })

  const blogs = computed<Blog[]>(() => data?.value?.pages?.flatMap(page => page.data ?? []) ?? [])

  // --- Delete Blog ---
  const deleteMutation = useMutation<void, Error, number | string>({
    mutationFn: async (id) => {
      await blogStore.deleteBlog(id)
    },
    onMutate: (id) => { deletingBlogId.value = id },
    onError: (err) => handleApiError(err),
    onSettled: () => { deletingBlogId.value = null },
  })

  const handleDelete = (id: number | string) => {
    if (!confirm('Are you sure you want to delete this blog?')) return
    deleteMutation.mutate(id)
  }

  // --- Update Blog ---
  const updateBlogMutation = useMutation({
    mutationFn: async ({ id, data }: { id: number | string; data: BlogData }) =>
      blogStore.updateBlog(id, data),
    onError: (err) => handleApiError(err),
  })

  // --- Edit Blog Navigation ---
  const handleEdit = (id: number | string) => {
    router.push({ name: 'EditBlog', params: { id } })
  }

  // --- Load More ---
  const loadMore = async () => {
    if (hasNextPage.value && !isFetchingNextPage.value) await fetchNextPage()
  }

  return {
    blogs,
    status,
    error,
    deletingBlogId,
    currentUserId,
    auth,
    errorStore,
    deleteMutation,
    updateBlogMutation,
    handleDelete,
    handleEdit,
    formatTimeAgo,
    hasNextPage,
    isFetchingNextPage,
    loadMore,
  }
}
