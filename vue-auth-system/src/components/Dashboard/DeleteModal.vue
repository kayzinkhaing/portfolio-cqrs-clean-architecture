<template>
  <!-- Teleport modal to body -->
  <teleport to="body">
    <div
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-96 p-6">
        <h2 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">
          Confirm Delete
        </h2>
        <p class="text-gray-600 dark:text-gray-300 mb-6">
          Are you sure you want to delete this item? This action cannot be undone.
        </p>

        <div class="flex justify-end space-x-3">
          <button
            @click="$emit('cancel')"
            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 rounded hover:bg-gray-300 dark:hover:bg-gray-600"
          >
            Cancel
          </button>
          <button
            @click="$emit('confirm')"
            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
          >
            Delete
          </button>
        </div>
      </div>
    </div>
  </teleport>
</template>

<script setup lang="ts">
// No additional script needed as we use emits
</script>

<style scoped>
/* Optional: Add simple fade-in animation */
div[teleport] {
  animation: fadeIn 0.2s ease-in-out;
}

@keyframes fadeIn {
  from { opacity: 0 }
  to { opacity: 1 }
}
</style>
