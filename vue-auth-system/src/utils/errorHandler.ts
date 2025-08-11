// src/utils/errorHandler.ts
import { useErrorStore } from '@/stores/errorStore'

export function handleApiError(error: unknown) {
  const errorStore = useErrorStore()

  if (error && typeof error === 'object' && 'response' in error) {
    const err = error as any
    const status = err.response?.status

    if (status === 422) {
      // Laravel validation errors
      errorStore.setValidationErrors(err.response.data.errors)
    } else if (status === 401) {
      errorStore.setGeneralError('Unauthorized. Please log in again.')
    } else {
      errorStore.setGeneralError(err.response?.data?.message || 'An unexpected error occurred.')
    }
  } else {
    errorStore.setGeneralError('Network error. Please try again.')
  }
}
