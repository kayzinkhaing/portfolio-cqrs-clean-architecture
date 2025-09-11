// src/composables/__tests__/useRegister.spec.ts
import { describe, it, expect, vi, beforeEach } from 'vitest'
import { useRegister, RegisterForm } from '../useRegister'
import { nextTick } from 'vue'

// ------------------------
// Mocks
// ------------------------

// Router mock
const routerPushMock = vi.fn()
vi.mock('vue-router', () => ({
  useRouter: () => ({ push: routerPushMock }),
}))

// Error store mock
const errorStoreMock = {
  errors: {},
  generalMessage: '',
  clearErrors: vi.fn(),
  setValidationErrors: vi.fn(),
  setGeneralError: vi.fn(),
}
vi.mock('../../stores/errorStore', () => ({
  useErrorStore: () => errorStoreMock,
}))

// API mocks
const getTownshipsMock = vi.fn()
const getWardsMock = vi.fn()
vi.mock('../../api/queries/locationQuery', () => ({
  getTownships: () => getTownshipsMock(),
  getWards: (townshipId: number) => getWardsMock(townshipId),
}))

const registerUserMock = vi.fn()
vi.mock('../../api/commands/authCommand', () => ({
  registerUser: (payload: any) => registerUserMock(payload),
}))

// Validation mock
const validateRegisterFormMock = vi.fn((form: RegisterForm) => ({}))
vi.mock('../../utils/registerValidation', () => ({
  validateRegisterForm: (form: RegisterForm) => validateRegisterFormMock(form),
}))

// Error handler
const handleApiErrorMock = vi.fn()
vi.mock('../../utils/errorHandler', () => ({
  handleApiError: (err: unknown) => handleApiErrorMock(err),
}))

// API loader mock
vi.mock('../../composables/useApiLoader', () => ({
  useApiLoader: () => ({
    load: async (fn: () => Promise<any>) => await fn(),
  }),
}))

// Secure form mock
vi.mock('../../composables/useSecureForm', () => ({
  useSecureForm: () => ({ isSubmitting: { value: false } }),
}))

// ------------------------
// Reset mocks before each test
// ------------------------
beforeEach(() => {
  vi.clearAllMocks()
  routerPushMock.mockReset()
  errorStoreMock.errors = {}
  errorStoreMock.generalMessage = ''
})

// ------------------------
// Tests
// ------------------------
describe('useRegister composable', () => {
  it('should expose default form state', () => {
    const { form, townships, wards, filteredWards } = useRegister()
    expect(form.value).toEqual({
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      township_id: null,
      ward_id: null,
    })
    expect(townships.value).toEqual([])
    expect(wards.value).toEqual([])
    expect(filteredWards.value).toEqual([])
  })

  // it('loads townships on mount', async () => { ... })

  it('loads wards when township_id changes', async () => {
    getWardsMock.mockResolvedValueOnce([{ id: '1', name: 'Ward A', township_id: 5 }])

    const { form, wards } = useRegister()
    form.value.township_id = 5
    await nextTick() // wait for watcher to trigger
    await nextTick() // sometimes two ticks needed for async watch

    expect(getWardsMock).toHaveBeenCalledWith(5)
    expect(wards.value).toEqual([{ id: '1', name: 'Ward A', township_id: 5 }])
  })

  it('short-circuits on validation errors', async () => {
    validateRegisterFormMock.mockReturnValueOnce({ email: ['Email is required'] })

    const { handleRegister, form } = useRegister()
    form.value.email = ''
    await handleRegister()

    expect(errorStoreMock.clearErrors).toHaveBeenCalled()
    expect(errorStoreMock.setValidationErrors).toHaveBeenCalledWith({ email: ['Email is required'] })
    expect(registerUserMock).not.toHaveBeenCalled()
  })

  it('registers and redirects to login on success', async () => {
    registerUserMock.mockResolvedValueOnce({ data: { user: {}, access_token: 'abc' } })

    const { form, handleRegister } = useRegister()
    form.value = {
      name: 'Test',
      email: 'test@example.com',
      password: 'secret123',
      password_confirmation: 'secret123',
      township_id: 1,
      ward_id: '2',
    }

    await handleRegister()

    expect(registerUserMock).toHaveBeenCalled()
    expect(routerPushMock).toHaveBeenCalledWith('/home/login')
  })

  it('sets general error if registration fails', async () => {
    registerUserMock.mockResolvedValueOnce({ message: 'Email already taken' })

    const { handleRegister } = useRegister()
    await handleRegister()

    expect(errorStoreMock.setGeneralError).toHaveBeenCalledWith('Email already taken')
  })

  it('handles API error with handleApiError', async () => {
    registerUserMock.mockRejectedValueOnce(new Error('Network fail'))

    const { handleRegister } = useRegister()
    await handleRegister()

    expect(handleApiErrorMock).toHaveBeenCalled()
  })
})
