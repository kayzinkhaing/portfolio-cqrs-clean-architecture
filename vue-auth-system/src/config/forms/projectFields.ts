import type { FormField } from '@/types/form'

export const projectFields = (): FormField[] => [
  {
    type: 'text',
    label: 'Title',
    model: 'title',
    placeholder: 'Enter project title',
  },
  {
    type: 'textarea',
    label: 'Description',
    model: 'description',
    placeholder: 'Enter project description',
  },
  {
    type: 'select',
    label: 'Status',
    model: 'status_id',
    options: [], // dynamically filled later
    placeholder: 'Select status',
  },
  {
    type: 'date',
    label: 'Start Date',
    model: 'start_date',
  },
  {
    type: 'date',
    label: 'End Date',
    model: 'end_date',
  },
  {
    type: 'checkbox',
    label: 'Featured Project',
    model: 'is_featured',
  },
]
