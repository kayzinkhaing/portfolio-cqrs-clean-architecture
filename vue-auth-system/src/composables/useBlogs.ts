import { ref, computed } from 'vue'
import { useInfiniteQuery, useMutation, useQueryClient,QueryFunctionContext } from '@tanstack/vue-query'
import type { InfiniteData } from '@tanstack/query-core'

import { getBlogs, deleteBlog } from '../services/api'
import { useAuthStore } from '../stores/auth'
import { useErrorStore } from '../stores/errorStore'
import { handleApiError } from '../utils/errorHandler'

// --- Types ---
interface User {
  id: number | string
  name: string
}

interface Blog {
  id: number | string
  title: string
  excerpt?: string | null
  content: string
  user?: User | null
}

interface BlogResponse {
  data: Blog[]
  next_page_url: string | null
}

type QueryKey = readonly ['blogs']

export default function useBlogs() {
  // Stores
  const auth = useAuthStore()
  const errorStore = useErrorStore()
  const queryClient = useQueryClient()

  // State
  const deletingBlogId = ref<number | string | null>(null)
  const currentUserId = computed(() => auth.user?.id)

  const showAll = ref(false)

  // Fetch function
  const fetchBlogs = async (context: QueryFunctionContext<QueryKey>): Promise<BlogResponse> => {
    const pageParam = context.pageParam ?? null
    const params = pageParam ? { cursor: pageParam as string } : {}
    const res = await getBlogs(params)
    return res.data
  }

  // Infinite Query
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
    getNextPageParam: (lastPage) => {
      if (lastPage.next_page_url) {
        const url = new URL(lastPage.next_page_url)
        return url.searchParams.get('cursor') || undefined
      }
      return undefined
    },
    initialPageParam: null,
    staleTime: 1000 * 60 * 5,
  })

  // Flatten blogs
  const blogs = computed<Blog[]>(() => {
    if (!data?.value?.pages) return []
    return ([] as Blog[]).concat(...data.value.pages.map(page => page.data ?? []))
  })


  // Delete mutation
  const deleteMutation = useMutation<void, Error, number | string>({
    mutationFn: (id) => deleteBlog(id).then(() => {}),
    onMutate: (id) => {
      deletingBlogId.value = id
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['blogs'] })
    },
    onError: (err) => {
      handleApiError(err)
    },
    onSettled: () => {
      deletingBlogId.value = null
    },
  })

  // Handlers
  function handleDelete(id: number | string) {
    if (!confirm('Are you sure you want to delete this blog?')) return
    deleteMutation.mutate(id)
  }

  // Load next page if available
  async function onLoadMore() {
    if (hasNextPage.value && !isFetchingNextPage.value) {
      await fetchNextPage()
      // After fetching next page, automatically show all blogs
      showAll.value = true
    } else {
      // If no more pages to fetch, just toggle showAll
      showAll.value = !showAll.value
    }
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
    handleDelete,
    hasNextPage,
    isFetchingNextPage,
    onLoadMore,
    showAll,
    fetchNextPage
  }
}
