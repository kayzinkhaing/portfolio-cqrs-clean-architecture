// import type { Township, Ward } from '@/types' // if you have types defined

export interface Field {
  model: string
  type: string
  label?: string
  placeholder?: string
  required?: boolean
  options?: any[]
  props?: Record<string, any>
}

export function blogFields(): Field[] {
  return [
    {
      model: 'title',
      type: 'text',
      label: 'Title',
      placeholder: 'Enter blog title',
      required: true,
    },
    {
      model: 'excerpt',
      type: 'text',
      label: 'Excerpt',
      placeholder: 'Optional short description',
    },
    {
      model: 'content',
      type: 'textarea',
      label: 'Content',
      placeholder: 'Write your blog content here...',
      required: true,
      props: { rows: 6 },
    },
    {
      model: 'published_at',
      type: 'datetime-local',
      label: 'Publish Date',
    },
  ]
}
