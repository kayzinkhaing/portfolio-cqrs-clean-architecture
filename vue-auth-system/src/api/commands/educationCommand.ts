// src/api/commands/educationCommand.ts
import type { EducationFormData, Education } from '@/types/education'
import { commandApi, withCsrf } from '../axios'
import { ROUTES } from '../routes'

// Generic wrapper for commands
async function executeCommand<T>(fn: () => Promise<T>): Promise<T | null> {
  try {
    return await fn()
  } catch (error) {
    console.error('Education command failed:', error)
    return null
  }
}

// -------------------------
// Create Education
// -------------------------
export const createEducation = (data: EducationFormData): Promise<Education | null> =>
  executeCommand(() =>
    withCsrf(() =>
      commandApi.post<Education>(ROUTES.educations.list, data)
    ).then(res => res.data)
  )

// -------------------------
// Update Education
// -------------------------
export const updateEducationCommand = (id: number | string, data: EducationFormData): Promise<Education | null> =>
  executeCommand(() =>
    withCsrf(() =>
      commandApi.put<Education>(ROUTES.educations.item(id), data)
    ).then(res => res.data)
  )

// -------------------------
// Delete Education
// -------------------------
export const deleteEducation = (id: number | string): Promise<boolean> =>
  executeCommand(() =>
    withCsrf(() =>
      commandApi.delete(ROUTES.educations.item(id))
    ).then(() => true)
  ).then(res => !!res)
