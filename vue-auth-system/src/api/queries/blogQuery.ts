import { gql } from '@apollo/client/core'
import { gqlClient } from '../gql/client'
import type { Blog } from '../types'

// ----------------------
// GraphQL Queries
// ----------------------
const GET_BLOGS = gql`
  query GetBlogs($limit: Int, $search: String) {
    blogs(limit: $limit, search: $search) {
      id
      title
      excerpt
      content
      published_at
      created_at
      updated_at
      user {
        id
        name
        email
        township { id name }
        ward { id name township_id }
      }
    }
  }
`

const GET_BLOG_BY_ID = gql`
  query GetBlogById($id: ID!) {
    blog(id: $id) {
      id
      title
      excerpt
      content
      published_at
      created_at
      updated_at
      user {
        id
        name
        email
        township { id name }
        ward { id name township_id }
      }
    }
  }
`

// ----------------------
// API Functions
// ----------------------
export async function fetchBlogs(limit = 20, search = ''): Promise<Blog[]> {
  const { data } = await gqlClient.query<{ blogs: Blog[] }>({
    query: GET_BLOGS,
    variables: { limit, search },
    fetchPolicy: 'network-only',
  })
  return data.blogs
}

export async function fetchBlogById(id: string): Promise<Blog | null> {
  const { data } = await gqlClient.query<{ blog: Blog }>({
    query: GET_BLOG_BY_ID,
    variables: { id },
    fetchPolicy: 'network-only',
  })
  return data.blog ?? null
}
