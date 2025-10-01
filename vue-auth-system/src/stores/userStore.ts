import { defineStore } from 'pinia'
import { ref } from 'vue'
import { getUsers } from '@/api/queries/userQuery'

export const useUserStore = defineStore('user', () => {
  const user = ref({
    name: 'Kay Zin Khaing',
    email: '',
    township: { name: 'Myanmar' },
    ward: { name: '', township_id: '' }
  })
  const loaded = ref(false)

  async function fetchUser() {
    if (loaded.value) return // already fetched, skip
    try {
      const users = await getUsers()
      if (users.length > 0) {
        user.value = users[0]
      }
      loaded.value = true
    } catch (err) {
      console.error('Failed to fetch user:', err)
    }
  }

  return { user, fetchUser }
})
