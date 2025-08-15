// src/composables/useProfile.ts
import { ref, onMounted, computed, watch, reactive } from 'vue'
import { useRouter } from 'vue-router'
import { getTownships, getWards } from '../services/location'
import { useAuthStore } from '../stores/auth'
import { profileFields } from '../config/forms/profileFields'

interface Township {
  id: number | string
  name: string
}

interface Ward {
  id: number | string
  township_id: number | string
  name: string
}

export function useProfile() {
  const router = useRouter()
  const auth = useAuthStore()

  const townships = ref<Township[]>([])
  const wards = ref<Ward[]>([])
  const pageLoading = ref(true)

  // Create a local reactive copy of the user to edit form data independently
  const localUser = reactive({ ...auth.user })

  // Whenever auth.user changes (e.g. after login), sync localUser
  watch(() => auth.user, (newUser) => {
    if (newUser) {
      Object.assign(localUser, newUser)
    }
  }, { immediate: true })

  const filteredWards = computed(() => {
    if (!localUser.township_id) return []
    return wards.value.filter(w => w.township_id === localUser.township_id)
  })

  const loadWards = async () => {
    if (!localUser.township_id) {
      wards.value = []
      localUser.ward_id = '' as any
      return
    }
    const res = await getWards()
    wards.value = res.data
  }

  onMounted(async () => {
    try {
      if (!auth.user) await auth.fetchUser()
      const townshipsRes = await getTownships()
      townships.value = townshipsRes.data
      await loadWards()
    } catch {
      router.push('/login')
    } finally {
      pageLoading.value = false
    }
  })

  watch(() => localUser.township_id, loadWards)

  const fields = computed(() =>
    profileFields(townships.value, filteredWards.value, auth.loading)
  )

  const update = async () => {
    try {
      // Update using localUser data, not directly auth.user
      await auth.updateUserProfile(localUser)
      router.push('/settings/info')
    } catch (error) {
      console.error('Profile update failed:', error)
    }
  }

  return {
    auth,
    fields,
    pageLoading,
    update,
    localUser,  
  }
}
