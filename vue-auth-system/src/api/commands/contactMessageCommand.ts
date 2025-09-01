import type { ContactMessageData, ContactMessage } from '../../types/contact'
import { publicApi } from '../axios'
import { ROUTES } from '../routes'

// -------------------------
// Create a new contact message (public form)
// -------------------------
export const createContactMessage = async (
  data: ContactMessageData
): Promise<ContactMessage | null> => {
  try {
    const response = await publicApi.post<ContactMessage>(
      ROUTES.contactMessages.list,
      data
    )
    return response.data
  } catch (error) {
    console.error('Error creating contact message:', error)
    return null
  }
}

// -------------------------
// Update a contact message (requires auth, keep CSRF if needed)
// -------------------------
export const updateContactMessage = async (
  id: number | string,
  data: Partial<ContactMessageData>
): Promise<ContactMessage | null> => {
  try {
    const response = await publicApi.put<ContactMessage>(
      ROUTES.contactMessages.item(id),
      data
    )
    return response.data
  } catch (error) {
    console.error(`Error updating contact message ${id}:`, error)
    return null
  }
}

// -------------------------
// Delete a contact message (requires auth, keep CSRF if needed)
// -------------------------
export const deleteContactMessage = async (id: number | string): Promise<boolean> => {
  try {
    await publicApi.delete(ROUTES.contactMessages.item(id))
    return true
  } catch (error) {
    console.error(`Error deleting contact message ${id}:`, error)
    return false
  }
}
