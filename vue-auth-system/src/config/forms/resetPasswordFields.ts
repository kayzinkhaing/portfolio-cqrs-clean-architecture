import type { Field } from '@/types/formTypes'

export const resetPasswordFields: Field[] = [
  { model: 'password', type: 'password', label: 'New Password', placeholder: 'New Password', required: true },
  { model: 'password_confirmation', type: 'password', label: 'Confirm Password', placeholder: 'Confirm Password', required: true }
]
