<template>
  <section class="max-w-2xl mx-auto py-12 px-4">
    <SectionTitle title="Let's Connect Together" class="mb-4" />

    <p class="text-gray-400 mb-8 text-center text-base">
      I’m open for freelance or full-time opportunities. Feel free to reach out.
    </p>

    <form
      @submit.prevent="submitMessage"
      class="bg-gray-800 p-8 rounded-xl shadow-2xl border border-gray-700 flex flex-col gap-5"
    >
      <div class="grid md:grid-cols-2 gap-4">
        <input
          v-model="form.name"
          type="text"
          placeholder="Your Full Name"
          class="w-full px-4 py-2.5 rounded-lg bg-gray-900 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-150 ease-in-out"
          required
        />
        <input
          v-model="form.email"
          type="email"
          placeholder="Email Address"
          class="w-full px-4 py-2.5 rounded-lg bg-gray-900 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-150 ease-in-out"
          required
        />
      </div>

      <input
        v-model="form.subject"
        type="text"
        placeholder="Subject (e.g., Project Inquiry, Job Offer)"
        class="w-full px-4 py-2.5 rounded-lg bg-gray-900 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-150 ease-in-out"
      />

      <textarea
        v-model="form.message"
        rows="4"
        placeholder="Write your detailed message here..."
        class="w-full px-4 py-2.5 rounded-lg bg-gray-900 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition duration-150 ease-in-out"
        required
      ></textarea>

      <button
        type="submit"
        :disabled="loading"
        class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white font-semibold py-2 px-4 rounded-md shadow hover:shadow-md transform hover:scale-105 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        <span v-if="loading">⏳ Sending Message...</span>
        <span v-else>✉️ Send Message</span>
      </button>
    </form>

    <Teleport to="body">
      <SuccessModal :show="showModal" @close="showModal = false" />
    </Teleport>
  </section>
</template>

<script setup lang="ts">
import { ref, defineAsyncComponent } from "vue";
import SectionTitle from "@/components/portfolio/SectionTitle.vue";
import { createContactMessage } from "@/api/commands/contactMessageCommand";
// Removing useToast as we are switching to a modal
// import { useToast } from "vue-toastification";

// Asynchronously load the modal component
const SuccessModal = defineAsyncComponent(() => import('@/components/modal/SuccessModal.vue'));

// const toast = useToast(); // No longer needed
const showModal = ref(false); // State for controlling the modal

const form = ref({
  name: "",
  email: "",
  subject: "",
  message: "",
});

const loading = ref(false);

const submitMessage = async () => {
  loading.value = true;
  try {
    const result = await createContactMessage(form.value);
    if (result) {
      // Show the modal instead of the toast
      showModal.value = true;
      // Clear the form on success
      form.value = { name: "", email: "", subject: "", message: "" };
    } else {
      // Use a simple alert or re-introduce a lightweight notification for errors
      alert("Failed to send message. Please try again.");
    }
  } catch (err) {
    alert("Unexpected error occurred.");
    console.error(err);
  } finally {
    loading.value = false;
  }
};
</script>