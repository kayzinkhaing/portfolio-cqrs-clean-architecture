export interface FormField {
  type: 'text' | 'textarea' | 'select' | 'checkbox' | 'date'
  label: string
  model: string
  placeholder?: string
  options?: { label: string; value: string | number }[]
  props?: Record<string, any>
}
