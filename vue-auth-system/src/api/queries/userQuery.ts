import { gql } from '@apollo/client/core'
import { gqlClient } from '../gql/client'

export const GET_USERS = gql`
  query GetUsers {
    users {
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
    }
  }
`
export async function getUsers(): Promise<any[]> {
  try {
    const { data } = await gqlClient.query({
      query: GET_USERS,
      fetchPolicy: 'no-cache',
    })

    // Ensure the response is an array
    return Array.isArray(data.users) ? data.users : []
  } catch (err) {
    console.error('Error fetching users:', err)
    return []
  }
}
