// src/api/queries/blogQuery.ts
import { gql } from '@apollo/client/core'
import { gqlClient } from '../gql/client'
import type { Blog } from '../types'

// -------------------------
// GraphQL Query: Get All Blogs
// -------------------------
const GET_BLOGS = gql`
  query GetBlogs {
    blogs {
      id
      title
      content
      author {
        id
        name
      }
      created_at
      updated_at
    }
  }
`

// -------------------------
// GraphQL Query: Get Blog by ID
// -------------------------
const GET_BLOG_BY_ID = gql`
  query GetBlogById($id: ID!) {
    blog(id: $id) {
      id
      title
      content
      author {
        id
        name
      }
      created_at
      updated_at
    }
  }
`

// -------------------------
// Function to fetch all blogs
// -------------------------
export const fetchBlogs = async (): Promise<Blog[]> => {
  try {
    const { data } = await gqlClient.query<{ blogs: Blog[] }>({
      query: GET_BLOGS,
      fetchPolicy: 'network-only',
    })
    return data.blogs
  } catch (error) {
    console.error('Error fetching blogs:', error)
    return []
  }
}

// -------------------------
// Function to fetch single blog by ID
// -------------------------
export const fetchBlogById = async (id: string | number): Promise<Blog | null> => {
  try {
    const { data } = await gqlClient.query<{ blog: Blog }>({
      query: GET_BLOG_BY_ID,
      variables: { id },
      fetchPolicy: 'network-only',
    })
    return data.blog || null
  } catch (error) {
    console.error(`Error fetching blog ${id}:`, error)
    return null
  }
}
