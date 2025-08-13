<template>
  <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-md shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-indigo-600">My Profile</h2>
  
    <LoadingSpinner v-if="pageLoading" class="mx-auto" />
  
    <!-- <DynamicForm v-else :fields="fields" :form="auth.user || {}" :errors="auth.errors" :loading="auth.loading"
        submit-label="Update Profile" @submit="update" /> -->
    <DynamicForm :fields="fields" :form="localUser" :errors="auth.errors" :loading="auth.loading"
      submit-label="Update Profile" @submit="update" />
  
  </div>
</template>

<script setup lang="ts">
import LoadingSpinner from '../components/LoadingSpinner.vue'
import DynamicForm from '@/components/DynamicForm.vue'
import { useProfile } from '../composables/useProfile'

const { auth, fields, pageLoading, update, localUser } = useProfile()
</script>
