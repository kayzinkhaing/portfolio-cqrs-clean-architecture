// src/api/commands/projectCommand.ts
import type { ProjectFormData, Project } from '../../types/project'
import { commandApi, withCsrf } from '../axios'
import { ROUTES } from '../routes'

// Generic wrapper for commands
async function executeCommand<T>(fn: () => Promise<T>): Promise<T | null> {
  try {
    return await fn()
  } catch (error) {
    console.error('Project command failed:', error)
    return null
  }
}

// -------------------------
// Create Project
// -------------------------
export const createProject = (data: ProjectFormData): Promise<Project | null> =>
  executeCommand(() =>
    withCsrf(() =>
      commandApi.post<Project>(ROUTES.projects.list, data)
    ).then(res => res.data)
  )

// -------------------------
// Update Project
// -------------------------
export const updateProjectCommand = (id: number | string, data: ProjectFormData): Promise<Project | null> =>
  executeCommand(() =>
    withCsrf(() =>
      commandApi.put<Project>(ROUTES.projects.item(id), data)
    ).then(res => res.data)
  )

// -------------------------
// Delete Project
// -------------------------
export const deleteProject = (id: number | string): Promise<boolean> =>
  executeCommand(() =>
    withCsrf(() =>
      commandApi.delete(ROUTES.projects.item(id))
    ).then(() => true)
  ).then(res => !!res)
