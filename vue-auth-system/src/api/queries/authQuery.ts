// src/api/queries/authQuery.ts
import { gql } from '@apollo/client/core'
import { gqlClient } from '../gql/client'
import type { User } from '../types'

// GraphQL Query
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
        township_id
      }
      two_factor_enabled
      created_at
      updated_at
    }
  }
`

// Function to fetch current user
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
