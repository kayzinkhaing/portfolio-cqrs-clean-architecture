import { gql } from '@apollo/client/core'
import { gqlClient } from '../gql/client'

// -------------------------
// GraphQL Queries
// -------------------------
export const GET_TOWNSHIPS = gql`
  query GetTownships {
    townships {
      id
      name
    }
  }
`

export const GET_WARDS = gql`
  query GetWards($townshipId: ID!) {
    wards(township_id: $townshipId) {
      id
      name
      township {
        id
        name
      }
      created_at
      updated_at
    }
  }
`

// -------------------------
// Functions
// -------------------------
export async function getTownships(): Promise<{ id: number; name: string }[]> {
  try {
    const { data } = await gqlClient.query({
      query: GET_TOWNSHIPS,
      fetchPolicy: 'no-cache',
    })
    return Array.isArray(data.townships) ? data.townships : []
  } catch (err) {
    console.error('Error fetching townships:', err)
    return []
  }
}

export async function getWards(townshipId: number): Promise<any[]> {
  try {
    const { data } = await gqlClient.query({
      query: GET_WARDS,
      variables: { townshipId },
      fetchPolicy: 'no-cache',
    })

    if (!Array.isArray(data.wards)) return []

    return data.wards.map((w: any) => ({
      id: w.id,
      name: w.name,
      township_id: townshipId,
      township: w.township ?? { id: 0, name: '' },
    }))
  } catch (err) {
    console.error('Error fetching wards:', err)
    return []
  }
}
