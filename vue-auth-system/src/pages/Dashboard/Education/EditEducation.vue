<template>
  <div>
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Edit Education</h1>
      <RouterLink
        to="/dashboard/education"
        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 rounded-md"
      >
        Back
      </RouterLink>
    </div>

    <!-- Loading / Error -->
    <div v-if="loading" class="text-center py-10">Loading education data...</div>
    <div v-else-if="error" class="text-center py-10 text-red-500">{{ error.message }}</div>

    <!-- Form -->
    <div v-else class="bg-white dark:bg-gray-800 shadow rounded-xl p-6 max-w-2xl mx-auto">
      <form @submit.prevent="submitForm" class="space-y-4">
        <!-- Institution -->
        <div>
          <label class="block text-gray-700 dark:text-gray-200 mb-1">Institution</label>
          <input
            v-model="form.institution"
            type="text"
            class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
            required
          />
        </div>

        <!-- Degree -->
        <div>
          <label class="block text-gray-700 dark:text-gray-200 mb-1">Degree</label>
          <input
            v-model="form.degree"
            type="text"
            class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
            required
          />
        </div>

        <!-- Location -->
        <div>
          <label class="block text-gray-700 dark:text-gray-200 mb-1">Location</label>
          <input
            v-model="form.location"
            type="text"
            class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
            required
          />
        </div>

        <!-- Start & End Dates -->
        <div class="flex space-x-4">
          <div class="flex-1">
            <label class="block text-gray-700 dark:text-gray-200 mb-1">Start Date</label>
            <input
              v-model="form.start_date"
              type="date"
              class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
              required
            />
          </div>
          <div class="flex-1">
            <label class="block text-gray-700 dark:text-gray-200 mb-1">End Date</label>
            <input
              v-model="form.end_date"
              type="date"
              class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
            />
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Leave empty if ongoing</p>
          </div>
        </div>

        <!-- Details -->
        <div>
          <label class="block text-gray-700 dark:text-gray-200 mb-1">Details</label>
          <textarea
            v-model="form.details"
            rows="4"
            class="w-full px-3 py-2 border rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
          ></textarea>
        </div>

        <!-- Submit -->
        <div class="flex justify-end space-x-2">
          <RouterLink
            to="/dashboard/education"
            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-100 rounded-md"
          >
            Cancel
          </RouterLink>
          <button
            type="submit"
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md"
          >
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useQuery } from '@vue/apollo-composable'
import { GET_EDUCATION } from '@/api/queries/educationQuery'
import { updateEducationCommand } from '@/api/commands/educationCommand'
import type { Education, EducationFormData } from '@/types/education'

const route = useRoute()
const router = useRouter()
const educationId = route.params.id as string

// Form state
const form = ref<EducationFormData>({
  institution: '',
  degree: '',
  location: '',
  start_date: '',
  end_date: null,
  details: '',
  is_current: false,
})

// Fetch old data
const { result, loading, error } = useQuery<{ education: Education }>(
  GET_EDUCATION,
  { id: educationId }
)

// Prefill form when result changes
watch(result, (val) => {
  if (val?.education) {
    const edu = val.education
    form.value = {
      institution: edu.institution,
      degree: edu.degree,
      location: edu.location,
      start_date: edu.start_date,
      end_date: edu.end_date,
      details: edu.details,
      is_current: edu.is_current,
    }
  }
})

// Submit update
async function submitForm() {
  const updated = await updateEducationCommand(educationId, form.value)
  if (updated) {
    router.push('/dashboard/education')
  } else {
    alert('Failed to update education. Check console for errors.')
  }
}
</script>

<style scoped>
input:focus,
textarea:focus {
  outline: none;
  border-color: #6366f1; /* Indigo-600 */
  box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
  transition: all 0.2s;
}
</style>
