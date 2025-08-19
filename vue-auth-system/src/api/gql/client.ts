// src/api/gql/client.ts
import { ApolloClient, InMemoryCache, HttpLink, from } from '@apollo/client/core'
import { setContext } from '@apollo/client/link/context'

// -------------------------
// GraphQL HTTP Link
// -------------------------
const httpLink = new HttpLink({
  uri: import.meta.env.VITE_GRAPHQL_URL || 'http://localhost:4000', // Read Model
})

// -------------------------
// Auth Middleware
// -------------------------
const authLink = setContext((_, { headers }) => {
  const token = localStorage.getItem('token') // or Vuex/Pinia
  return {
    headers: {
      ...headers,
      Authorization: token ? `Bearer ${token}` : '',
    },
  }
})

// -------------------------
// Apollo Client (Read API)
// -------------------------
export const gqlClient = new ApolloClient({
  link: from([authLink, httpLink]),
  cache: new InMemoryCache(),
})
