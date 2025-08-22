<!-- src/pages/Settings/ProfileEdit.vue -->
<template>
  <div class="max-w-2xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-bold text-indigo-600">Edit Profile</h2>
      <router-link
        to="/settings"
        class="text-sm text-gray-500 hover:text-indigo-600 transition"
      >
        ← Back
      </router-link>
    </div>

    <!-- Loading spinner -->
    <LoadingSpinner v-if="pageLoading" class="mx-auto" />

    <!-- Dynamic form -->
    <DynamicForm
      v-else
      :fields="fields"
      :form="localUser"
      :errors="auth.errors"
      :loading="auth.loading"
      submit-label="Save Changes"
      @submit="update"
    />
  </div>
</template>

<script setup lang="ts">
import LoadingSpinner from '@/components/LoadingSpinner.vue'
import DynamicForm from '@/components/forms/DynamicForm.vue'
import { useProfile } from '@/composables/useProfile'

// Reuse the composable — keeps this file clean
const { auth, fields, pageLoading, update, localUser } = useProfile()
</script>
