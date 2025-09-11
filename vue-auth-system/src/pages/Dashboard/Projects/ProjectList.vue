<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Projects</h1>
      <RouterLink to="/dashboard/projects/create" class="px-4 py-2 bg-indigo-600 text-white rounded">
        + New Project
      </RouterLink>
    </div>

    <div v-if="loading" class="text-center py-10">Loading projects...</div>
    <div v-else-if="error" class="text-center py-10 text-red-500">{{ error.message }}</div>

    <div v-else class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">
      <table class="min-w-full text-sm text-left">
        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200">
          <tr>
            <th class="px-6 py-3">Title</th>
            <th class="px-6 py-3">Description</th>
            <th class="px-6 py-3">Status</th>
            <th class="px-6 py-3">Technologies</th>
            <th class="px-6 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="project in sortedProjects" :key="project.id" class="border-b dark:border-gray-700">
            <td class="px-6 py-4">{{ project.title }}</td>
            <td class="px-6 py-4 max-w-xs">
              <div v-if="project.description?.length > 100">
                <span v-if="!expandedDescriptions[project.id]">
                  {{ project.description.substring(0, 100) }}
                  <button 
                    @click="toggleDescription(project.id)"
                    class="text-indigo-600 hover:text-indigo-800 ml-1"
                  >
                    ...more
                  </button>
                </span>
                <span v-else>
                  {{ project.description }}
                  <button 
                    @click="toggleDescription(project.id)"
                    class="text-indigo-600 hover:text-indigo-800 ml-1"
                  >
                    less
                  </button>
                </span>
              </div>
              <div v-else>
                {{ project.description }}
              </div>
            </td>
            <td class="px-6 py-4">
              <span :class="statusClass(project.status?.name)">
                {{ project.status?.name }}
              </span>
            </td>
            <td class="px-6 py-4">
              {{ project.technologies?.map(t => t.name).join(', ') }}
            </td>
            <td class="px-6 py-4 text-right space-x-2">
              <RouterLink :to="`/dashboard/projects/edit/${project.id}`" class="text-indigo-600 hover:text-indigo-800">
                <PencilIcon class="w-5 h-5 inline" />
              </RouterLink>
              <button class="text-red-600 hover:text-red-800" @click="confirmDelete(project.id)">
                <TrashIcon class="w-5 h-5 inline" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Pagination Controls -->
      <div class="flex justify-between items-center px-6 py-4 bg-gray-50 dark:bg-gray-700">
        <button
          @click="goToPage(pagination.current - 1)"
          :disabled="pagination.current === 1"
          class="px-3 py-1 rounded bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 disabled:opacity-50"
        >
          Prev
        </button>
        <span>Page {{ pagination.current }} / {{ pagination.lastPage }}</span>
        <button
          @click="goToPage(pagination.current + 1)"
          :disabled="pagination.current === pagination.lastPage"
          class="px-3 py-1 rounded bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 disabled:opacity-50"
        >
          Next
        </button>
      </div>
    </div>

    <!-- Delete Modal -->
    <DeleteModal v-if="showDeleteModal" @confirm="deleteProject" @cancel="showDeleteModal=false" />
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { RouterLink } from 'vue-router'
import { useProjects } from '../../../composables/useProjects'
import DeleteModal from '@/components/Dashboard/DeleteModal.vue'
import { PencilIcon, TrashIcon } from '@heroicons/vue/24/outline'
import { deleteProject as deleteProjectCommand } from '../../../api/commands/projectCommand'

// ----------------------
// Projects Composable (Paginated)
// ----------------------
const { projects, loading, error, pagination, goToPage, refetch } = useProjects(1, 5)

const sortedProjects = computed(() => [...projects.value].sort((a,b) => Number(b.id) - Number(a.id)))

// ----------------------
// Description Expansion
// ----------------------
const expandedDescriptions = ref<Record<number, boolean>>({})

function toggleDescription(projectId: number) {
  expandedDescriptions.value[projectId] = !expandedDescriptions.value[projectId]
}

// ----------------------
// Delete Project
// ----------------------
const showDeleteModal = ref(false)
let projectToDelete: number | null = null

function confirmDelete(id: number) {
  projectToDelete = id
  showDeleteModal.value = true
}

async function deleteProject() {
  if (!projectToDelete) return
  await deleteProjectCommand(projectToDelete)
  showDeleteModal.value = false
  projectToDelete = null
  refetch() // Refresh current page
}

// ----------------------
// Status badge
// ----------------------
function statusClass(statusName?: string) {
  return [
    'px-2 py-1 rounded-full text-xs font-medium',
    statusName === 'Active' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-600'
  ]
}
</script>