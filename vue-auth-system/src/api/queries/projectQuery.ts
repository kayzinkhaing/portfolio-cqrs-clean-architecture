// C:\xampp\htdocs\vue-testing-project\vue-auth-system\src\api\queries\projectQuery.ts

import { gql } from '@apollo/client/core'
import { gqlClient } from '../gql/client'

// --------------------
// GraphQL Queries
// --------------------

// Paginated projects query
export const GET_PROJECTS = gql`
  query GetProjects($page: Int, $per_page: Int) {
    projects(page: $page, per_page: $per_page) {
      data {
        id
        title
        slug
        description
        status { id name }
        start_date
        end_date
        is_featured
        technologies {
          id
          name
          slug
          icon
          created_at
          updated_at
        }
        created_at
        updated_at
      }
      current
      per_page
      total
      last_page
    }
  }
`

// Single project query
export const GET_PROJECT = gql`
  query GetProject($id: ID!) {
    project(id: $id) {
      id
      title
      slug
      description
      status { id name }
      start_date
      end_date
      is_featured
      technologies {
        id
        name
        slug
        icon
        created_at
        updated_at
      }
      created_at
      updated_at
    }
  }
`

// --------------------
// DRY Helper Functions
// --------------------

/**
 * Generic paginated fetcher for any GraphQL query
 */
async function fetchPaginated<T>(
  query: any,
  variables: Record<string, any>
): Promise<T | null> {
  try {
    const { data } = await gqlClient.query({
      query,
      variables,
      fetchPolicy: 'no-cache',
    })
    return data ? Object.values(data)[0] as T : null
  } catch (err) {
    console.error('GraphQL pagination error:', err)
    return null
  }
}

/**
 * Generic single fetcher for any GraphQL query
 */
async function fetchSingle<T>(
  query: any,
  variables: Record<string, any>
): Promise<T | null> {
  try {
    const { data } = await gqlClient.query({
      query,
      variables,
      fetchPolicy: 'no-cache',
    })
    return data ? Object.values(data)[0] as T : null
  } catch (err) {
    console.error('GraphQL single fetch error:', err)
    return null
  }
}

// --------------------
// Exported API Methods
// --------------------

/**
 * Fetch paginated projects
 */
export async function getProjects(
  page = 1,
  perPage = 10
): Promise<{
  data: any[]
  current: number
  per_page: number
  total: number
  last_page: number
} | null> {
  return fetchPaginated(GET_PROJECTS, { page, per_page: perPage })
}

/**
 * Fetch a single project by ID
 */
export async function getProject(id: number | string): Promise<any | null> {
  if (!id) return null
  return fetchSingle(GET_PROJECT, { id: id.toString() })
}

// --------------------
// Example: DRY reusable function for other entities
// --------------------
export async function getPaginatedEntity(
  query: any,
  page = 1,
  perPage = 10
): Promise<any | null> {
  return fetchPaginated(query, { page, per_page: perPage })
}

export async function getSingleEntity(query: any, variables: Record<string, any>) {
  return fetchSingle(query, variables)
}
