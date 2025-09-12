<template>
  <div class="max-w-2xl mx-auto py-4">
    <h1 class="text-lg font-semibold mb-3">Create New Project</h1>

    <!-- Form -->
    <form
      @submit.prevent="submitForm"
      class="bg-white dark:bg-gray-800 shadow rounded-lg p-3 space-y-2"
    >
      <!-- Title -->
      <div>
        <label class="block text-sm font-medium mb-0.5" for="title">Title *</label>
        <input
          v-model="form.title"
          id="title"
          type="text"
          class="w-full px-2 py-1 border rounded dark:bg-gray-700 dark:border-gray-600 text-sm"
          placeholder="Project title"
        />
        <p v-if="errors.title" class="text-red-500 text-xs mt-0.5">{{ errors.title }}</p>
      </div>

      <!-- Description -->
      <div>
        <label class="block text-sm font-medium mb-0.5" for="description">Description</label>
        <textarea
          v-model="form.description"
          id="description"
          rows="2"
          class="w-full px-2 py-1 border rounded dark:bg-gray-700 dark:border-gray-600 text-sm"
          placeholder="Project description"
        ></textarea>
        <p v-if="errors.description" class="text-red-500 text-xs mt-0.5">{{ errors.description }}</p>
      </div>

      <!-- Status -->
      <div>
        <label class="block text-sm font-medium mb-0.5" for="status">Status *</label>
        <select
          v-model="form.status_id"
          id="status"
          class="w-full px-2 py-1 border rounded dark:bg-gray-700 dark:border-gray-600 text-sm"
        >
          <option value="">Select status</option>
          <option v-for="status in statuses" :key="status.id" :value="status.id">
            {{ status.name }}
          </option>
        </select>
        <p v-if="errors.status_id" class="text-red-500 text-xs mt-0.5">{{ errors.status_id }}</p>
      </div>

      <!-- Technologies -->
      <div>
        <label class="block text-sm font-medium mb-0.5">Technologies</label>
        <div class="flex flex-wrap gap-1">
          <label
            v-for="tech in technologies"
            :key="tech.id"
            class="inline-flex items-center px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700 rounded cursor-pointer hover:bg-indigo-100 dark:hover:bg-indigo-800 text-xs"
          >
            <input
              type="checkbox"
              class="mr-1"
              :value="tech.id"
              v-model="form.technology_ids"
            />
            {{ tech.name }}
          </label>
        </div>
        <p v-if="errors.technology_ids" class="text-red-500 text-xs mt-0.5">{{ errors.technology_ids }}</p>
      </div>

      <!-- Dates -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-1">
        <div>
          <label class="block text-sm font-medium mb-0.5" for="start_date">Start *</label>
          <input
            v-model="form.start_date"
            id="start_date"
            type="date"
            class="w-full px-2 py-1 border rounded dark:bg-gray-700 dark:border-gray-600 text-sm"
          />
          <p v-if="errors.start_date" class="text-red-500 text-xs mt-0.5">{{ errors.start_date }}</p>
        </div>
        <div>
          <label class="block text-sm font-medium mb-0.5" for="end_date">End *</label>
          <input
            v-model="form.end_date"
            id="end_date"
            type="date"
            class="w-full px-2 py-1 border rounded dark:bg-gray-700 dark:border-gray-600 text-sm"
          />
          <p v-if="errors.end_date" class="text-red-500 text-xs mt-0.5">{{ errors.end_date }}</p>
        </div>
      </div>

      <!-- Featured -->
      <div class="flex items-center gap-1">
        <input type="checkbox" id="is_featured" v-model="form.is_featured" class="w-3 h-3"/>
        <label for="is_featured" class="text-sm font-medium">Featured</label>
      </div>

      <!-- Submit -->
      <div class="pt-2 flex items-center gap-1">
        <button
          type="submit"
          :disabled="submitting"
          class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-sm disabled:opacity-50 transition"
        >
          {{ submitting ? "Creating..." : "Create" }}
        </button>
        <RouterLink
          to="/dashboard/projects"
          class="px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded text-sm transition"
        >
          Cancel
        </RouterLink>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRouter, RouterLink } from "vue-router";
import { getStatuses } from "@/api/queries/statusQuery";
import { getTechnologies } from "@/api/queries/technologyQuery";
import { createProject } from "@/api/commands/projectCommand";
import type { Status } from "@/types/status";
import type { Technology } from "@/types/technology";
import type { ProjectFormData } from "@/types/project";

const router = useRouter();

const form = ref({
  title: "",
  description: "",
  status_id: "",
  technology_ids: [] as number[],
  start_date: "",
  end_date: "",
  is_featured: false,
});

const statuses = ref<Status[]>([]);
const technologies = ref<Technology[]>([]);
const submitting = ref(false);

// Object to hold field-specific errors from backend
const errors = ref<Record<string, string>>({});

// ----------------------
// Load Statuses & Technologies
// ----------------------
async function loadStatuses() {
  statuses.value = await getStatuses();
}

async function loadTechnologies() {
  technologies.value = await getTechnologies();
}

onMounted(() => {
  loadStatuses();
  loadTechnologies();
});

// ----------------------
// Submit Form
// ----------------------
async function submitForm() {
  errors.value = {}; // reset previous errors

  // Client-side validation
  if (!form.value.title || !form.value.status_id || !form.value.start_date || !form.value.end_date) {
    alert("Please fill in required fields: Title, Status, Start Date, End Date.");
    return;
  }

  submitting.value = true;

  const payload: ProjectFormData = {
    title: form.value.title,
    description: form.value.description || "", // ensure string
    status_id: Number(form.value.status_id),
    technology_ids: form.value.technology_ids.map(Number),
    start_date: form.value.start_date,
    end_date: form.value.end_date,
    is_featured: Boolean(form.value.is_featured),
  };

  try {
    const created = await createProject(payload);

    if (created) {
      router.push("/dashboard/projects");
    }
  } catch (err: any) {
    // If backend validation fails (422), show per-field errors
    if (err.response?.status === 422 && err.response.data?.errors) {
      errors.value = err.response.data.errors;
    } else {
      console.error("Create project failed:", err);
      alert(err.message || "Failed to create project");
    }
  } finally {
    submitting.value = false;
  }
}
</script>
