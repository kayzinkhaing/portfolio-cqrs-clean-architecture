import { gqlClient } from '../gql/client'
import { GET_TOWNSHIPS, GET_WARDS } from '../gql/queries'

export const getTownships = async () => {
  const { data } = await gqlClient.query<{ townships: any[] }>({
    query: GET_TOWNSHIPS,
    fetchPolicy: 'network-only',
  })
  return data.townships
}

export const getWards = async () => {
  const { data } = await gqlClient.query<{ wards: any[] }>({
    query: GET_WARDS,
    fetchPolicy: 'network-only',
  })
  return data.wards
}
