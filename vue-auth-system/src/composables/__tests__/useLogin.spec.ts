// src/composables/__tests__/useLogin.spec.ts
import { describe, it, expect, vi, beforeEach } from 'vitest'
import { useLogin } from '../useLogin'

// --- Router mock ---
const routerPushMock = vi.fn()
vi.mock('vue-router', () => ({
  useRouter: () => ({ push: routerPushMock }),
}))

// --- Error store mock ---
const errorStoreMock = {
  errors: {},
  generalMessage: '',
  clearErrors: vi.fn(),
  setValidationErrors: vi.fn(),
  setGeneralError: vi.fn(),
}
vi.mock('../../stores/errorStore.js', () => ({
  useErrorStore: () => errorStoreMock,
}))

// --- Auth store mock ---
const authStoreMock = {
  error: null,
  requires2FA: false,
  login: vi.fn(),
}
vi.mock('../../stores/auth', () => ({
  useAuthStore: () => authStoreMock,
}))

// --- Utils mocks ---
vi.mock('../../utils/errorHandler', () => ({
  handleApiError: vi.fn(),
}))
vi.mock('../../utils/sanitize', () => ({
  sanitizeObject: (obj: any) => obj,
}))
vi.mock('../../utils/loginValidation', () => ({
  validateLoginForm: vi.fn(() => ({})),
}))
vi.mock('../useApiLoader', () => ({
  useApiLoader: () => ({
    load: async (fn: () => Promise<any>, loading: { value: boolean }) => {
      loading.value = true
      try {
        return await fn()
      } finally {
        loading.value = false
      }
    },
  }),
}))

// Reset before each test
beforeEach(() => {
  vi.clearAllMocks()
  routerPushMock.mockReset()
  errorStoreMock.errors = {}
  errorStoreMock.generalMessage = ''
  authStoreMock.error = null
  authStoreMock.requires2FA = false
})

// -------------------------
// Tests
// -------------------------

it('should expose default state', () => {
  const { form, isLoading } = useLogin()
  expect(form.value).toEqual({ email: '', password: '' })
  expect(isLoading.value).toBe(false)
})

it('goToForgotPassword navigates correctly', () => {
  const { goToForgotPassword } = useLogin()
  goToForgotPassword()
  expect(routerPushMock).toHaveBeenCalledWith('/forgot-password')
})

it('should short-circuit on validation errors', async () => {
  const { validateLoginForm } = await import('../../utils/loginValidation')
  validateLoginForm.mockReturnValueOnce({ email: ['Email is required'] })

  const { handleLogin } = useLogin()
  await handleLogin()

  expect(errorStoreMock.clearErrors).toHaveBeenCalled()
  expect(errorStoreMock.setValidationErrors).toHaveBeenCalledWith({ email: ['Email is required'] })
  expect(authStoreMock.login).not.toHaveBeenCalled()
})

it('logs in and routes to DashboardHome if no 2FA', async () => {
  authStoreMock.login.mockResolvedValueOnce(undefined)

  const { form, handleLogin } = useLogin()
  form.value.email = 'user@example.com'
  form.value.password = 'secret'

  await handleLogin()

  expect(authStoreMock.login).toHaveBeenCalledWith({
    email: 'user@example.com',
    password: 'secret',
  })
  expect(routerPushMock).toHaveBeenCalledWith({ name: 'DashboardHome' })
})

it('routes to TwoFactor if requires2FA is true', async () => {
  authStoreMock.login.mockImplementationOnce(async () => {
    authStoreMock.requires2FA = true
  })

  const { form, handleLogin } = useLogin()
  form.value.email = 'user@example.com'
  form.value.password = 'secret'

  await handleLogin()

  expect(routerPushMock).toHaveBeenCalledWith({ name: 'TwoFactor' })
})

it('surfaces store error after login', async () => {
  authStoreMock.login.mockImplementationOnce(async () => {
    authStoreMock.error = 'Invalid credentials'
  })

  const { form, handleLogin } = useLogin()
  form.value.email = 'user@example.com'
  form.value.password = 'wrong'

  await handleLogin()

  expect(errorStoreMock.setGeneralError).toHaveBeenCalledWith('Invalid credentials')
  expect(routerPushMock).not.toHaveBeenCalled()
})

it('handles thrown API error', async () => {
  const apiError = { response: { data: { message: 'Server down' } } }
  authStoreMock.login.mockRejectedValueOnce(apiError)

  const { form, handleLogin } = useLogin()
  form.value.email = 'user@example.com'
  form.value.password = 'secret'

  const { handleApiError } = await import('../../utils/errorHandler')

  await handleLogin()

  expect(handleApiError).toHaveBeenCalledWith(apiError)
  expect(errorStoreMock.setGeneralError).toHaveBeenCalledWith('Server down')
})
