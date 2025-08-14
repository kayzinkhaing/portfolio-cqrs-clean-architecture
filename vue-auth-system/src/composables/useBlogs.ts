import { ref, computed } from 'vue'
import { useInfiniteQuery, useMutation, useQueryClient, QueryFunctionContext } from '@tanstack/vue-query'
import type { InfiniteData } from '@tanstack/query-core'
import { getBlogs, deleteBlog, updateBlog, type Blog, type BlogResponse } from '@/services/blog'
import { useAuthStore } from '@/stores/auth'
import { useErrorStore } from '@/stores/errorStore'
import { handleApiError } from '@/utils/errorHandler'
import type { BlogData } from '@/services/types'

export default function useBlogs() {
  const auth = useAuthStore()
  const errorStore = useErrorStore()
  const queryClient = useQueryClient()

  const deletingBlogId = ref<number | string | null>(null)
  const currentUserId = computed(() => auth.user?.id)

  type QueryKey = ['blogs']

  // --- Fetch Blogs ---
  const fetchBlogs = async (context: QueryFunctionContext<QueryKey, unknown>): Promise<BlogResponse> => {
    const cursor = context.pageParam ?? null
    const params = cursor ? { cursor: String(cursor) } : undefined
    const res = await getBlogs(params)
    return res.data
  }

  const { data, fetchNextPage, hasNextPage, isFetchingNextPage, status, error } =
    useInfiniteQuery<BlogResponse, Error, InfiniteData<BlogResponse>, QueryKey>({
      queryKey: ['blogs'],
      queryFn: fetchBlogs,
      getNextPageParam: (lastPage) =>
        lastPage.next_page_url ? new URL(lastPage.next_page_url).searchParams.get('cursor') || undefined : undefined,
      initialPageParam: null,
      staleTime: 0, // always refetch to ensure fresh data
    })

  const blogs = computed<Blog[]>(() => data?.value?.pages?.flatMap(page => page.data ?? []) ?? [])

  // --- Delete Blog ---
  const deleteMutation = useMutation<void, Error, number | string>({
    mutationFn: (id) => deleteBlog(id).then(() => {}),
    onMutate: (id) => { deletingBlogId.value = id },
    onSuccess: (_, id) => {
      queryClient.setQueryData<InfiniteData<BlogResponse>>(['blogs'], (old) => {
        if (!old) return old
        const newPages = old.pages.map(page => ({ ...page, data: page.data.filter(b => b.id !== id) }))
        return { ...old, pages: newPages }
      })
    },
    onError: (err) => handleApiError(err),
    onSettled: () => { deletingBlogId.value = null },
  })

  const handleDelete = (id: number | string) => {
    if (!confirm('Are you sure you want to delete this blog?')) return
    deleteMutation.mutate(id)
  }

  // --- Update Blog ---
  const updateBlogMutation = useMutation({
    mutationFn: ({ id, data }: { id: number | string; data: BlogData }) =>
      updateBlog(id, data),
    onSuccess: (res) => {
      const updatedBlog: Blog = res.data

      // Update cache immediately
      queryClient.setQueryData<InfiniteData<BlogResponse>>(['blogs'], (old) => {
        if (!old) return old
        const newPages = old.pages.map((page) => ({
          ...page,
          data: page.data.map(b => (b.id === updatedBlog.id ? updatedBlog : b))
        }))
        return { ...old, pages: newPages }
      })

      // Optionally, refetch to ensure all data is fresh
      queryClient.invalidateQueries({ queryKey: ['blogs'] })
    },
    onError: (err) => handleApiError(err),
  })

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
    hasNextPage,
    isFetchingNextPage,
    loadMore,
  }
}
