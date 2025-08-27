<template>
  <section class="max-w-3xl mx-auto py-16 px-6">
    <!-- Section Title -->
    <SectionTitle title="Let's connect Together" />

    <!-- Subtitle -->
    <p class="text-white mb-10 text-center text-lg">
      I’m open for freelance or full-time opportunities. Feel free to reach out 🚀
    </p>

    <!-- Contact Form -->
    <form
      class="bg-gradient-to-br from-slate-800/60 to-slate-900/60 backdrop-blur-md p-8 rounded-2xl shadow-xl border border-slate-700 flex flex-col gap-6"
    >
      <!-- Name -->
      <div>
        <label class="block text-green-200 mb-2 text-sm font-medium">Your Name</label>
        <input
          type="text"
          placeholder="Enter your name"
          class="w-full px-4 py-3 rounded-lg bg-indigo-100 border border-indigo-200 text-gray-700 placeholder-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300 transition"
        />
      </div>

      <!-- Email -->
      <div>
        <label class="block text-green-200 mb-2 text-sm font-medium">Email Address</label>
        <input
          type="email"
          placeholder="Enter your email"
          class="w-full px-4 py-3 rounded-lg bg-indigo-100 border border-indigo-200 text-gray-700 placeholder-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300 transition"
        />
      </div>

      <!-- Message -->
      <div>
        <label class="block text-green-200 mb-2 text-sm font-medium">Message</label>
        <textarea
          rows="5"
          placeholder="Write your message..."
          class="w-full px-4 py-3 rounded-lg bg-indigo-100 border border-indigo-200 text-gray-700 placeholder-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-300 transition"
        ></textarea>
      </div>

      <!-- Submit Button -->
      <button
        type="submit"
        class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-2xl transform hover:scale-[1.02] transition-all duration-300"
      >
        ✉️ Send Message
      </button>
    </form>
  </section>
</template>

<script setup lang="ts">
import SectionTitle from "@/components/portfolio/SectionTitle.vue"
</script>
