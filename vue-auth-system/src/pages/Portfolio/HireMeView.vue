<template>
  <section class="max-w-xl mx-auto py-12 px-4">
    <!-- Section Title -->
    <SectionTitle title="Let's connect Together" />

    <!-- Subtitle -->
    <p class="text-white mb-6 text-center text-base">
      I’m open for freelance or full-time opportunities. Feel free to reach out
      🚀
    </p>

    <!-- Contact Form -->
    <form
      @submit.prevent="submitMessage"
      class="bg-gradient-to-br from-slate-800/60 to-slate-900/60 backdrop-blur-md p-6 rounded-xl shadow-lg border border-slate-700 flex flex-col gap-4"
    >
      <!-- Name -->
      <div>
        <label class="block text-green-200 mb-1 text-sm font-medium"
          >Your Name</label
        >
        <input
          v-model="form.name"
          type="text"
          placeholder="Enter your name"
          class="w-full px-3 py-2 rounded-md bg-indigo-100 border border-indigo-200 text-gray-700 placeholder-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-300 focus:border-indigo-300 transition"
          required
        />
      </div>

      <!-- Email -->
      <div>
        <label class="block text-green-200 mb-1 text-sm font-medium"
          >Email Address</label
        >
        <input
          v-model="form.email"
          type="email"
          placeholder="Enter your email"
          class="w-full px-3 py-2 rounded-md bg-indigo-100 border border-indigo-200 text-gray-700 placeholder-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-300 focus:border-indigo-300 transition"
          required
        />
      </div>

      <!-- Subject -->
      <div>
        <label class="block text-green-200 mb-1 text-sm font-medium"
          >Subject</label
        >
        <input
          v-model="form.subject"
          type="text"
          placeholder="Subject"
          class="w-full px-3 py-2 rounded-md bg-indigo-100 border border-indigo-200 text-gray-700 placeholder-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-300 focus:border-indigo-300 transition"
        />
      </div>

      <!-- Message -->
      <div>
        <label class="block text-green-200 mb-1 text-sm font-medium"
          >Message</label
        >
        <textarea
          v-model="form.message"
          rows="4"
          placeholder="Write your message..."
          class="w-full px-3 py-2 rounded-md bg-indigo-100 border border-indigo-200 text-gray-700 placeholder-indigo-400 focus:outline-none focus:ring-1 focus:ring-indigo-300 focus:border-indigo-300 transition"
          required
        ></textarea>
      </div>

      <!-- Submit Button -->
      <button
        type="submit"
        :disabled="loading"
        class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white font-semibold py-2 px-4 rounded-md shadow hover:shadow-md transform hover:scale-105 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        <span v-if="loading">⏳ Sending...</span>
        <span v-else>✉️ Send Message</span>
      </button>
    </form>
  </section>
</template>

<script setup lang="ts">
import { ref } from "vue";
import SectionTitle from "@/components/portfolio/SectionTitle.vue";
import { createContactMessage } from "@/api/commands/contactMessageCommand";
import { useToast } from "vue-toastification"; // optional toast

const toast = useToast();

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
      toast.success("Your message has been sent! 🎉");
      form.value = { name: "", email: "", subject: "", message: "" }; // reset form
    } else {
      toast.error("Failed to send message. Please try again.");
    }
  } catch (err) {
    toast.error("Unexpected error occurred.");
    console.error(err);
  } finally {
    loading.value = false;
  }
};
</script>
