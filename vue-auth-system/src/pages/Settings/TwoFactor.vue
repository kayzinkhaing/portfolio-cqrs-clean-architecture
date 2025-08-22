<template>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md space-y-6">
        <h2 class="text-2xl font-bold text-indigo-600 text-center">
            Two-Factor Authentication
        </h2>
    
        <!-- Short description -->
        <p class="text-gray-600 text-sm text-center">
            Two-Factor Authentication (2FA) adds an extra layer of security to your account.
            After enabling, you will need to enter a one-time code from your Authenticator app each time you log in.
        </p>
    
        <!-- 2FA Status -->
        <div class="flex items-center justify-between">
            <p class="text-lg font-medium">Status:</p>
            <TwoFactorStatus :enabled="auth.user?.two_factor_enabled || false" />
        </div>
    
        <LoadingSpinner v-if="loading" class="mx-auto" />
    
        <div v-else class="space-y-6">
            <!-- Enable 2FA flow -->
            <template v-if="!auth.user?.two_factor_enabled">
                <p class="text-gray-700 text-sm">
                    To enable 2FA, click the button below. You will be shown a QR code to scan with Google Authenticator,
                    Authy, or any compatible app.
                </p>
    
                <TwoFactorQRCode v-if="step === 'verify'" :qr="qr" />
    
                <p v-if="step === 'verify'" class="text-gray-700 text-sm">
                    After scanning the QR code, enter the 6-digit code shown in your app to verify.
                </p>
    
                <TwoFactorForm v-if="step === 'verify'" :form="verificationForm" :fields="verificationFields"
                    :errors="errors" :loading="loading" @submit="onVerify2FA" />
    
                <TwoFactorButtons v-if="step === 'initial'" :enabled="false" @enable="onEnable2FA" />
            </template>
    
            <!-- Disable 2FA flow -->
            <template v-else>
                <p class="text-gray-700 text-sm">
                    2FA is currently enabled. Disabling it will remove the extra layer of login protection.
                    We recommend keeping it enabled for better security.
                </p>
    
                <TwoFactorButtons :enabled="true" @disable="onDisable2FA" />
            </template>
    
            <p v-if="message" class="text-red-600 mt-2">{{ message }}</p>
        </div>
    </div>
</template>


<script setup lang="ts">
import LoadingSpinner from '../../components/LoadingSpinner.vue'
import TwoFactorForm from '@/components/TwoFactorForm.vue'
import TwoFactorButtons from '@/components/TwoFactorButtons.vue'
import TwoFactorQRCode from '@/components/TwoFactorQRCode.vue'
import TwoFactorStatus from '@/components/TwoFactorStatus.vue'
import { useTwoFactorAuth } from '@/composables/useTwoFactorAuth'

const {
  auth,
  loading,
  message,
  qr,
  step,
  verificationForm,
  verificationFields,
  errors,
  onEnable2FA,
  onVerify2FA,
  onDisable2FA,
} = useTwoFactorAuth()
</script>
