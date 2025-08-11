import type { Field } from '@/types/formTypes'

export const loginFields: Field[] = [
  {
    model: 'email',
    type: 'email',
    label: 'Email',
    placeholder: 'Email',
    required: true,
  },
  {
    model: 'password',
    type: 'password',
    label: 'Password',
    placeholder: 'Password',
    required: true,
  },
]
