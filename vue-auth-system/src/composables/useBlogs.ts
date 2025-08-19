// C:\xampp\htdocs\vue-testing-project\vue-auth-system\src\composables\useBlogs.ts
import { ref, computed } from 'vue'
import { useInfiniteQuery, useMutation, useQueryClient, QueryFunctionContext } from '@tanstack/vue-query'
import type { InfiniteData } from '@tanstack/query-core'
import { getBlogs, deleteBlog, updateBlog } from '@/services/blog'
import { Blog, BlogData, BlogResponse } from '@/api/types'
import { useAuthStore } from '@/stores/auth'
import { useErrorStore } from '@/stores/errorStore'
import { handleApiError } from '@/utils/errorHandler'
import { useRouter } from 'vue-router'
import { formatDistanceToNow, parseISO } from 'date-fns' 

export default function useBlogs() {
  const auth = useAuthStore()
  const errorStore = useErrorStore()
  const queryClient = useQueryClient()
  const router = useRouter()

  const deletingBlogId = ref<number | string | null>(null)
  const currentUserId = computed(() => auth.user?.id)
  type QueryKey = ['blogs']

  // --- New formatting function ---
  const formatTimeAgo = (isoDateString: string | undefined): string => {
    if (!isoDateString) return 'unknown'
    const date = parseISO(isoDateString)
    return formatDistanceToNow(date, { addSuffix: true })
  }

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
      staleTime: 0,
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
      queryClient.setQueryData<InfiniteData<BlogResponse>>(['blogs'], (old) => {
        if (!old) return old
        const newPages = old.pages.map((page) => ({
          ...page,
          data: page.data.map(b => (b.id === updatedBlog.id ? updatedBlog : b))
        }))
        return { ...old, pages: newPages }
      })
      queryClient.invalidateQueries({ queryKey: ['blogs'] })
    },
    onError: (err) => handleApiError(err),
  })

  // --- New `handleEdit` function ---
  const handleEdit = (id: number | string) => {
    router.push({ name: 'EditBlog', params: { id } })
  }

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
    formatTimeAgo, // 👈 Export the new function
    hasNextPage,
    isFetchingNextPage,
    loadMore,
  }
}