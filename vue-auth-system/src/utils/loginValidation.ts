// src/utils/validation/loginValidation.ts
import { addError, emailRegex, ValidationErrors } from './index'

export interface LoginForm {
  email: string
  password: string
}

export function validateLoginForm(form: LoginForm): ValidationErrors {
  const errors: ValidationErrors = {}

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

  return errors
}
