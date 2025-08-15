import type { Field } from '@/types/formTypes'

export const forgotPasswordFields: Field[] = [
  {
    model: 'email',
    type: 'email',
    label: 'Email',
    placeholder: 'Enter your email',
    required: true,
  },
]
