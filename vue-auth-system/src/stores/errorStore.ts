// src/stores/errorStore.ts
import { defineStore } from 'pinia'

export const useErrorStore = defineStore('error', {
  state: () => ({
    errors: {} as Record<string, string[]>,
    generalMessage: '' as string
  }),

  actions: {
    setValidationErrors(errors: Record<string, string[]>) {
      this.errors = errors
    },
    setGeneralError(message: string) {
      this.generalMessage = message
    },
    clearErrors() {
      this.errors = {}
      this.generalMessage = ''
    }
  }
})
