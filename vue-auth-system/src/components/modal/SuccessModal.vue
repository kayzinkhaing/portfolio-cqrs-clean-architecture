<template>
  <Transition name="modal-fade">
    <div
      v-if="show"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80 backdrop-blur-md"
      @click.self="$emit('close')"
    >
      <div
        class="bg-gray-900 p-10 rounded-3xl shadow-2xl max-w-md w-full border border-green-500/30 transform transition-all scale-100 opacity-100"
        role="dialog"
        aria-modal="true"
        aria-labelledby="success-title"
      >
        <div class="text-center">
          <div
            class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-600/10 mb-6 border border-green-500/50 animate-pulse-green"
          >
            <svg
              class="h-10 w-10 text-green-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 13l4 4L19 7"
              ></path>
            </svg>
          </div>
          
          <h3
            id="success-title"
            class="text-2xl font-extrabold text-white tracking-wide"
          >
            Success! Your message is launched 🎉
          </h3>
          
          <p class="mt-3 text-base text-gray-400 leading-relaxed">
            I appreciate you reaching out! I've received your inquiry and will review it promptly. Expect a reply within 1-2 business days.
          </p>
          
          <div class="mt-8">
            <button
              @click="$emit('close')"
              type="button"
              class="inline-flex w-full justify-center rounded-xl bg-green-600 px-6 py-3 text-lg font-semibold text-white shadow-lg hover:bg-green-500 focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-200"
            >
              Close Window
            </button>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup lang="ts">
// Define props and emits
defineProps<{
  show: boolean;
}>();

defineEmits(["close"]);
</script>

<style scoped>
/* Modal Fade Transition */
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.3s ease;
}
.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}

/* Modal Content Animation (Zoom-in/Zoom-out effect) */
.modal-fade-enter-active > div,
.modal-fade-leave-active > div {
  transition: all 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55); /* Bounce effect */
}
.modal-fade-enter-from > div,
.modal-fade-leave-to > div {
  transform: scale(0.8);
  opacity: 0;
}

/* Keyframe for subtle pulse animation on the icon background (Updated for Standard Green) */
@keyframes pulse-green {
  0%, 100% {
    box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); /* Equivalent to green-500/40 */
  }
  50% {
    box-shadow: 0 0 0 10px rgba(34, 197, 94, 0);
  }
}
.animate-pulse-green {
  animation: pulse-green 2s infinite;
}
</style>