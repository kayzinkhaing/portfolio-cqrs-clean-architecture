// src/utils/validation/registerValidation.ts
import { addError, emailRegex, ValidationErrors } from './index'

export interface RegisterForm {
  name: string
  email: string
  password: string
  password_confirmation: string
  township_id: string | number | null
  ward_id: string | number | null
}

export function validateRegisterForm(form: RegisterForm): ValidationErrors {
  const errors: ValidationErrors = {}

  if (!form.name) {
    addError(errors, 'name', 'Name is required')
  }

  if (!form.email) {
    addError(errors, 'email', 'Email is required')
  } else if (!emailRegex.test(form.email)) {
    addError(errors, 'email', 'Invalid email format')
  }

  if (!form.password) {
    addError(errors, 'password', 'Password is required')
  } else if (form.password.length < 6) {
    addError(errors, 'password', 'Password must be at least 6 characters')
  }

  if (!form.password_confirmation) {
    addError(errors, 'password_confirmation', 'Confirm Password is required')
  } else if (form.password !== form.password_confirmation) {
    addError(errors, 'password_confirmation', 'Passwords do not match')
  }

  if (!form.township_id) {
    addError(errors, 'township_id', 'Township is required')
  }

  if (!form.ward_id) {
    addError(errors, 'ward_id', 'Ward is required')
  }

  return errors
}
