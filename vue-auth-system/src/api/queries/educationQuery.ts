import { gql } from '@apollo/client/core'
import { gqlClient } from '../gql/client'

// =====================
// GraphQL Queries
// =====================

export const GET_EDUCATIONS = gql`
  query GetEducations {
    educations {
      id
      user_id
      institution
      degree
      location
      start_date
      end_date
      is_current
      details
      created_at
      updated_at
    }
  }
`

export const GET_EDUCATION = gql`
  query GetEducation($id: ID!) {
    education(id: $id) {
      id
      user_id
      institution
      degree
      location
      start_date
      end_date
      is_current
      details
      created_at
      updated_at
    }
  }
`

// =====================
// Functions
// =====================

export async function getEducations(): Promise<any[]> {
  try {
    const { data } = await gqlClient.query({
      query: GET_EDUCATIONS,
      fetchPolicy: 'no-cache', // optional: disables caching
    })
    return Array.isArray(data.educations) ? data.educations : []
  } catch (err) {
    console.error('Error fetching educations:', err)
    return []
  }
}

export async function getEducation(id: number | string): Promise<any | null> {
  try {
    const { data } = await gqlClient.query({
      query: GET_EDUCATION,
      variables: { id },
      fetchPolicy: 'no-cache',
    })
    return data.education ?? null
  } catch (err) {
    console.error(`Error fetching education ${id}:`, err)
    return null
  }
}
