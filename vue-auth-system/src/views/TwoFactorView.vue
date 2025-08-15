<template>
  <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-md shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-indigo-600">Two-Factor Authentication</h2>

    <p v-if="qrCode" class="mb-4">Scan QR code with your Authenticator app:</p>
    <div v-if="qrCode" v-html="qrCode" class="mb-4"></div>

    <input v-model="code" type="text" placeholder="Enter 6-digit code" class="border p-2 rounded w-full mb-2">
    <button @click="verify" class="w-full bg-indigo-600 text-white py-2 rounded">Verify</button>

    <p v-if="message" class="mt-2 text-red-600">{{ message }}</p>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { enable2FA, verify2FA } from '../services/auth'
import { useAuthStore } from '../stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const qrCode = ref<string>('')
const code = ref<string>('')
const message = ref<string>('')

// If 2FA not yet enabled, fetch QR code
const setup2FA = async () => {
  try {
    const res = await enable2FA()
    qrCode.value = res.data.qr
  } catch (err) {
    console.error(err)
  }
}

const verify = async () => {
  try {
    const res = await verify2FA(code.value)
    message.value = res.data.message
    if (res.data.success) {
      authStore.setTwoFactorVerified(true)
      router.push('/') // Redirect to home or previous page
    }
  } catch (err: any) {
    message.value = err.response?.data?.message || 'Verification failed'
  }
}

setup2FA()
</script>
