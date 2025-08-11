// src/composables/useApiLoader.ts
import { ref, type Ref } from 'vue'
import { handleApiError } from '@/utils/errorHandler'

export function useApiLoader(loadingRef?: Ref<boolean>) {
  const defaultLoading = ref(false)
  const loading = loadingRef || defaultLoading

  async function load<T>(fn: () => Promise<T>, customLoading?: Ref<boolean>): Promise<T | undefined> {
    const targetLoading = customLoading || loading
    targetLoading.value = true
    try {
      return await fn()
    } catch (err) {
      handleApiError(err) // Global error handling
    } finally {
      targetLoading.value = false
    }
  }

  return { loading, load }
}
