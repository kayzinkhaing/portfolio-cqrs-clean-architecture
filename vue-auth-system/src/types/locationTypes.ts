export interface Township {
  id: number | string
  name: string
}

export interface Ward {
  id: number | string
  township_id: number | string
  name: string
}
