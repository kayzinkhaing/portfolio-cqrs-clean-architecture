// src/utils/validation/blogValidation.ts

import type { BlogForm } from '@/views/CreateBlogView.vue' // or define again here if no circular imports

export function validateBlogForm(form: BlogForm): Record<string, string> {
  const errors: Record<string, string> = {}

  if (!form.title || form.title.trim() === '') {
    errors.title = 'Title is required'
  }

  // excerpt is optional, so no validation needed

  if (!form.content || form.content.trim() === '') {
    errors.content = 'Content is required'
  }

  // published_at is optional, but if you want to check valid date format:
  if (form.published_at && isNaN(Date.parse(form.published_at))) {
    errors.published_at = 'Publish date is invalid'
  }

  return errors
}
