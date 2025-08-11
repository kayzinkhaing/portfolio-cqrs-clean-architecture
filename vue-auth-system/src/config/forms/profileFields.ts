// src/config/forms/profileFields.ts
import type { Field } from '@/types/formTypes'
import type { Township, Ward } from '@/types/locationTypes'

export const profileFields = (
  townships: Township[],
  filteredWards: Ward[],
  isDisabled: boolean
): Field[] => [
  {
    model: 'name',
    type: 'text',
    label: 'Name',
    required: true,
    props: { disabled: isDisabled },
  },
  {
    model: 'email',
    type: 'email',
    label: 'Email',
    required: true,
    props: { disabled: isDisabled },
  },
  {
    model: 'township_id',
    type: 'select',
    label: 'Township',
    placeholder: 'Select Township',
    options: townships,
    required: true,
    props: { disabled: isDisabled },
  },
  {
    model: 'ward_id',
    type: 'select',
    label: 'Ward',
    placeholder: 'Select Ward',
    options: filteredWards,
    required: true,
    props: { disabled: isDisabled },
  },
]
