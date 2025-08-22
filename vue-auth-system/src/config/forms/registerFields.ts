// src/config/forms/registerFields.ts
import type { Township, Ward } from '@/types/locationTypes'

export const registerFields = (townships: Township[], filteredWards: Ward[]) => [
  { model: 'name', type: 'text', label: 'Name', placeholder: 'Name', required: true },
  { model: 'email', type: 'email', label: 'Email', placeholder: 'Email', required: true },
  { model: 'password', type: 'password', label: 'Password', placeholder: 'Password', required: true },
  { model: 'password_confirmation', type: 'password', label: 'Confirm Password', placeholder: 'Confirm Password', required: true },
  {
    model: 'township_id',
    type: 'select',
    label: 'Township',
    placeholder: 'Select Township',
    options: townships.map((t) => ({
      id: t.id,
      name: t.name,
    })), // ✅ reactive townships
    required: true,
  },
  {
    model: 'ward_id',
    type: 'select',
    label: 'Ward',
    placeholder: 'Select Ward',
    options: filteredWards.map((w) => ({
      id: w.id,
      name: w.name,
    })), // ✅ reactive wards
    required: true,
  },
]
