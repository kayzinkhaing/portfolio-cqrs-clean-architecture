import { gql } from '@apollo/client/core'
import { gqlClient } from '../gql/client'

// -------------------------
// GraphQL Query
// -------------------------
export const GET_STATUSES = gql`
  query GetStatuses {
    statuses {
      id
      name
    }
  }
`

// -------------------------
// Query Function
// -------------------------
export async function getStatuses(): Promise<any[]> {
  try {
    const { data } = await gqlClient.query({
      query: GET_STATUSES,
      fetchPolicy: 'no-cache', // optional: disables caching
    })

    // Ensure we return an array
    return Array.isArray(data.statuses) ? data.statuses : []
  } catch (err) {
    console.error('Error fetching statuses:', err)
    return []
  }
}
