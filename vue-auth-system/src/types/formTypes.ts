export interface Field {
  model: string
  type: string
  label?: string
  placeholder?: string
  options?: any[]
  required?: boolean
  props?: Record<string, any>
}
