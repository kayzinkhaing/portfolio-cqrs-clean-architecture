import { gql } from '@apollo/client/core'
import { gqlClient } from '../gql/client'

export const GET_EXPERIENCES = gql`
  query GetExperiences {
    experiences {
      id
      position
      company
      location
      start_date
      end_date
      responsibilities
      created_at
      updated_at
    }
  }
`

export async function getExperiences(): Promise<any[]> {
  try {
    const { data } = await gqlClient.query({
      query: GET_EXPERIENCES,
      fetchPolicy: 'no-cache',
    })
    return Array.isArray(data.experiences) ? data.experiences : []
  } catch (err) {
    console.error('Error fetching experiences:', err)
    return []
  }
}
