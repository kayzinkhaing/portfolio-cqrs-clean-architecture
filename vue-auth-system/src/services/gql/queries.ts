import { gql } from 'graphql-tag';

export const QUERY_BLOGS = gql`
  query Blogs($page: Int, $limit: Int) {
    blogs(page: $page, limit: $limit) {
      data { id title excerpt author { id name } createdAt }
      total
      page
      limit
    }
  }
`;

export const QUERY_BLOG = gql`
  query Blog($id: ID!) {
    blog(id: $id) {
      id title content author { id name } createdAt updatedAt
    }
  }
`;
