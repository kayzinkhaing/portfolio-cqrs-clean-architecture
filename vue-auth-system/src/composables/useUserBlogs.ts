// src/composables/useUserBlogs.ts
import { ref, computed } from 'vue'
import { useInfiniteQuery, useMutation, useQueryClient, QueryFunctionContext } from '@tanstack/vue-query'
import type { InfiniteData } from '@tanstack/query-core'
import { getUserBlogs, deleteBlog, updateBlog } from '@/services/blog'
import { Blog, BlogData, BlogResponse } from '@/services/types'
import { useAuthStore } from '@/stores/auth'
import { useErrorStore } from '@/stores/errorStore'
import { handleApiError } from '@/utils/errorHandler'
import { useRouter } from 'vue-router'
import { formatDistanceToNow, parseISO } from 'date-fns'

export default function useUserBlogs() {
  const auth = useAuthStore()
  const errorStore = useErrorStore()
  const queryClient = useQueryClient()
  const router = useRouter()

  const deletingBlogId = ref<number | string | null>(null)
  const currentUserId = computed(() => auth.user?.id)
  type QueryKey = ['user-blogs', number | string | undefined]

  const formatTimeAgo = (isoDateString: string | undefined | null): string => {
    if (!isoDateString) return 'unknown'
    const date = parseISO(isoDateString)
    return formatDistanceToNow(date, { addSuffix: true })
  }

  // Use the user's ID to fetch only their blogs
  const fetchUserBlogs = async (context: QueryFunctionContext<QueryKey, unknown>): Promise<BlogResponse> => {
    const [_, userId] = context.queryKey
    if (!userId) throw new Error('User ID is required to fetch blogs.')

    const cursor = context.pageParam ?? null
    const params = cursor ? { cursor: String(cursor) } : undefined
    const res = await getUserBlogs(userId, params)
    return res.data
  }

  const { data, fetchNextPage, hasNextPage, isFetchingNextPage, status, error } =
    useInfiniteQuery<BlogResponse, Error, InfiniteData<BlogResponse>, QueryKey>({
      queryKey: ['user-blogs', currentUserId],
      queryFn: fetchUserBlogs,
      enabled: computed(() => !!currentUserId.value), // Only run query if user ID exists
      getNextPageParam: (lastPage) =>
        lastPage.next_page_url ? new URL(lastPage.next_page_url).searchParams.get('cursor') || undefined : undefined,
      initialPageParam: null,
      staleTime: 0,
    })

  const blogs = computed<Blog[]>(() => data?.value?.pages?.flatMap(page => page.data ?? []) ?? [])

  const deleteMutation = useMutation<void, Error, number | string>({
    mutationFn: (id) => deleteBlog(id).then(() => {}),
    onMutate: (id) => { deletingBlogId.value = id },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['user-blogs', currentUserId.value] })
    },
    onError: (err) => handleApiError(err),
    onSettled: () => { deletingBlogId.value = null },
  })

  const handleDelete = (id: number | string) => {
    if (!confirm('Are you sure you want to delete this blog?')) return
    deleteMutation.mutate(id)
  }

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
    handleDelete,
    handleEdit,
    formatTimeAgo,
    hasNextPage,
    isFetchingNextPage,
    loadMore,
  }
}