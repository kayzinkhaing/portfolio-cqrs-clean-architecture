// C:\xampp\htdocs\vue-testing-project\vue-auth-system\src\api\queries\technologyQuery.ts

import { gql } from '@apollo/client/core'
import { gqlClient } from '../gql/client'

// -------------------------
// GraphQL Query
// -------------------------
export const GET_TECHNOLOGIES = gql`
  query GetTechnologies {
    technologies {
      id
      name
      slug
      icon
    }
  }
`

// -------------------------
// Query Function
// -------------------------
export async function getTechnologies(): Promise<any[]> {
  try {
    const { data } = await gqlClient.query({
      query: GET_TECHNOLOGIES,
      fetchPolicy: 'no-cache', // disables caching
    })

    // Ensure we return an array
    return Array.isArray(data.technologies) ? data.technologies : []
  } catch (err) {
    console.error('Error fetching technologies:', err)
    return []
  }
}
