// src/utils/sanitize.ts
import DOMPurify from 'dompurify'

// Removes all HTML/JS and trims spaces
export function sanitizeInput(value: string): string {
  return DOMPurify.sanitize(value, { ALLOWED_TAGS: [], ALLOWED_ATTR: [] }).trim()
}

// Sanitizes an entire object
export function sanitizeObject(obj: Record<string, any>) {
  const clean: Record<string, any> = {}
  for (const key in obj) {
    if (typeof obj[key] === 'string') {
      clean[key] = sanitizeInput(obj[key])
    } else {
      clean[key] = obj[key]
    }
  }
  return clean
}
