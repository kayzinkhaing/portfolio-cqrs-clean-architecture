// src/api/gql/client.ts
import { ApolloClient, InMemoryCache, HttpLink, from } from '@apollo/client/core'
import { setContext } from '@apollo/client/link/context'
import { onError } from '@apollo/client/link/error'

// -------------------------
// 1) HTTP link via Vite proxy
// -------------------------
// const httpLink = new HttpLink({
//   uri: '/graphql', // Vite proxy will forward to Laravel
// })


const httpLink = new HttpLink({
  uri: import.meta.env.VITE_GRAPHQL_URL || 'http://localhost:8000/graphql', // Read Model
})

// -------------------------
// 2) Auth link (optional)
// -------------------------
const authLink = setContext((_, { headers }) => {
  const token = localStorage.getItem('token')
  return {
    headers: {
      ...headers,
      Authorization: token ? `Bearer ${token}` : '',
    },
  }
})

// -------------------------
// 3) Error logging link
// -------------------------
const errorLink = onError(({ graphQLErrors, networkError, response }) => {
  if (graphQLErrors) {
    graphQLErrors.forEach(({ message, path }) => 
      console.error(`[GraphQL error] ${message} at ${path?.join('.')}`)
    )
  }
  if (networkError) console.error(`[Network error]`, networkError)
  if (response) console.log('GraphQL response:', response)
})

// -------------------------
// 4) Apollo Client
// -------------------------
export const gqlClient = new ApolloClient({
  link: from([errorLink, authLink, httpLink]),
  cache: new InMemoryCache(),
})
