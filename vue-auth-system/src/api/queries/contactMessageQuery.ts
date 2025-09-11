import { gql } from '@apollo/client/core'
import { gqlClient } from '../gql/client'

// =====================
// GraphQL Queries
// =====================

export const GET_UNREAD_CONTACT_MESSAGES = gql`
  query GetUnreadContactMessages {
    unreadContactMessages {
      id
      name
      email
      subject
      message
      is_read
      created_at
      updated_at
    }
  }
`;

export const GET_CONTACT_MESSAGES = gql`
  query GetContactMessages {
    contactMessages {
      id
      name
      email
      subject
      message
      is_read
      created_at
      updated_at
    }
  }
`

export const GET_CONTACT_MESSAGE = gql`
  query GetContactMessage($id: ID!) {
    contactMessage(id: $id) {
      id
      name
      email
      subject
      message
      is_read
      created_at
      updated_at
    }
  }
`

// =====================
// Functions
// =====================
export async function getUnreadContactMessages(): Promise<any[]> {
  try {
    const { data } = await gqlClient.query({
      query: GET_UNREAD_CONTACT_MESSAGES,
      fetchPolicy: 'no-cache',
    });
    // return only the array
    return Array.isArray(data.unreadContactMessages)
      ? data.unreadContactMessages
      : [];
  } catch (err) {
    console.error('Error fetching unread contact messages:', err);
    return [];
  }
}

export async function getContactMessages(): Promise<any[]> {
  try {
    const { data } = await gqlClient.query({
      query: GET_CONTACT_MESSAGES,
      fetchPolicy: 'no-cache', // optional: disables caching
    })
    return Array.isArray(data.contactMessages) ? data.contactMessages : []
  } catch (err) {
    console.error('Error fetching contact messages:', err)
    return []
  }
}

export async function getContactMessage(id: number | string): Promise<any | null> {
  try {
    const { data } = await gqlClient.query({
      query: GET_CONTACT_MESSAGE,
      variables: { id },
      fetchPolicy: 'no-cache',
    })
    return data.contactMessage ?? null
  } catch (err) {
    console.error(`Error fetching contact message ${id}:`, err)
    return null
  }
}
