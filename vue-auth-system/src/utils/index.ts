// src/utils/validation/index.ts
// # common helpers (addError, shared regex, etc.)
// Common reusable error type
export type ValidationErrors = Record<string, string[]>

// Common helper to add an error
export function addError(errors: ValidationErrors, field: string, message: string) {
  if (!errors[field]) {
    errors[field] = []
  }
  errors[field].push(message)
}

// Common regex patterns
export const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
