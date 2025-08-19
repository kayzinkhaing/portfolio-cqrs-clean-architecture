// src/api/queries/authQuery.ts
import { gql } from '@apollo/client'
import { gqlClient } from '../gql/client'
import type { User } from '../types'

// -------------------------
// GraphQL Query: Get Current User
// -------------------------
const GET_CURRENT_USER = gql`
  query GetCurrentUser {
    currentUser {
      id
      name
      email
      township {
        id
        name
      }
      ward {
        id
        name
      }
      two_factor_enabled
      created_at
      updated_at
    }
  }
`

// -------------------------
// Function to fetch current user
// -------------------------
// src/api/queries/authQuery.ts
export const getProfileUser = async (): Promise<User | null> => {
  try {
    const { data } = await gqlClient.query<{ currentUser: User }>({
      query: GET_CURRENT_USER,
      fetchPolicy: 'network-only',
    })
    return data.currentUser || null
  } catch (error) {
    console.error('Error fetching current user:', error)
    return null
  }
}

