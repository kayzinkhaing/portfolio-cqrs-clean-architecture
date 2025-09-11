<template>
  <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 shadow rounded-xl p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">Edit Project</h1>

    <form @submit.prevent="submitUpdate">
      <!-- Title -->
      <div class="mb-4">
        <label class="block mb-1 text-gray-700 dark:text-gray-200">Title</label>
        <input
          v-model="form.title"
          type="text"
          class="w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:border-gray-600"
          required
        />
      </div>

      <!-- Description -->
      <div class="mb-4">
        <label class="block mb-1 text-gray-700 dark:text-gray-200">Description</label>
        <textarea
          v-model="form.description"
          rows="4"
          class="w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:border-gray-600"
        ></textarea>
      </div>

      <!-- Status -->
      <div class="mb-4">
        <label class="block mb-1 text-gray-700 dark:text-gray-200">Status</label>
        <select
          v-model="form.status_id"
          class="w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:border-gray-600"
        >
          <option value="">Select status</option>
          <option v-for="status in statuses" :key="status.id" :value="status.id">
            {{ status.name }}
          </option>
        </select>
      </div>

      <!-- Technologies (Checkboxes) -->
      <div class="mb-4">
        <label class="block mb-1 text-gray-700 dark:text-gray-200">Technologies</label>
        <div class="flex flex-wrap gap-2">
          <label
            v-for="tech in allTechnologies"
            :key="tech.id"
            class="inline-flex items-center px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded cursor-pointer hover:bg-indigo-100 dark:hover:bg-indigo-800 transition"
          >
            <input
              type="checkbox"
              class="mr-2"
              :value="tech.id"
              v-model="form.technology_ids"
            />
            {{ tech.name }}
          </label>
        </div>
      </div>

      <!-- Dates -->
      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block mb-1 text-gray-700 dark:text-gray-200">Start Date</label>
          <input
            v-model="form.start_date"
            type="date"
            class="w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:border-gray-600"
          />
        </div>
        <div>
          <label class="block mb-1 text-gray-700 dark:text-gray-200">End Date</label>
          <input
            v-model="form.end_date"
            type="date"
            class="w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:border-gray-600"
          />
        </div>
      </div>

      <!-- Featured -->
      <div class="mb-4 flex items-center space-x-2">
        <input
          v-model="form.is_featured"
          type="checkbox"
          class="w-4 h-4 text-indigo-600 rounded"
        />
        <label class="text-gray-700 dark:text-gray-200">Featured Project</label>
      </div>

      <!-- Actions -->
      <div class="flex justify-end space-x-3">
        <RouterLink
          to="/dashboard/projects"
          class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded-md"
        >
          Cancel
        </RouterLink>
        <button
          type="submit"
          class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md"
          :disabled="loading"
        >
          {{ loading ? 'Saving...' : 'Save Changes' }}
        </button>
      </div>

      <!-- Error Message -->
      <div v-if="error" class="mt-4 text-red-500">{{ error }}</div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute, useRouter, RouterLink } from 'vue-router'
import { gqlClient } from '../../../api/gql/client'
import { GET_PROJECT } from '../../../api/queries/projectQuery'
import { GET_STATUSES } from '../../../api/queries/statusQuery'
import { GET_TECHNOLOGIES } from '../../../api/queries/technologyQuery'
import { updateProjectCommand } from '../../../api/commands/projectCommand'
import type { Project, ProjectFormData } from '../../../types/project'

const route = useRoute()
const router = useRouter()
const projectId = Number(route.params.id)

const form = ref<ProjectFormData>({
  title: '',
  description: '',
  status_id: '',
  technology_ids: [],
  start_date: '',
  end_date: '',
  is_featured: false,
})

const statuses = ref<{ id: number; name: string }[]>([])
const allTechnologies = ref<{ id: number; name: string }[]>([])

const loading = ref(false)
const error = ref<string | null>(null)

// ----------------------
// Load project, statuses & technologies
// ----------------------
async function loadFormData() {
  try {
    const { data: statusData } = await gqlClient.query({
      query: GET_STATUSES,
      fetchPolicy: 'no-cache',
    })
    statuses.value = statusData.statuses ?? []

    const { data: techData } = await gqlClient.query({
      query: GET_TECHNOLOGIES,
      fetchPolicy: 'no-cache',
    })
    allTechnologies.value = techData.technologies ?? []

    const { data: projectData } = await gqlClient.query({
      query: GET_PROJECT,
      variables: { id: projectId },
      fetchPolicy: 'no-cache',
    })
    const project: Project = projectData.project

    form.value.title = project.title
    form.value.description = project.description ?? ''
    form.value.status_id = project.status?.id ? String(project.status.id) : ''
    form.value.technology_ids = project.technologies?.map(t => t.id) ?? []
    form.value.start_date = project.start_date
    form.value.end_date = project.end_date
    form.value.is_featured = project.is_featured
  } catch (err: any) {
    error.value = err.message || 'Failed to load project data'
  }
}

// ----------------------
// Submit form
// ----------------------
async function submitUpdate() {
  loading.value = true
  error.value = null

  try {
    await updateProjectCommand(projectId, {
      ...form.value,
      status_id: Number(form.value.status_id),
    })
    router.push('/dashboard/projects')
  } catch (err: any) {
    error.value = err.response?.data?.message || err.message || 'Failed to update project'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadFormData()
})
</script>
