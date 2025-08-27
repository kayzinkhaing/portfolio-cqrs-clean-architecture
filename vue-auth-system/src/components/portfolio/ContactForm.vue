<template>
  <form @submit.prevent="submitForm" class="space-y-6">
    <div class="grid md:grid-cols-2 gap-6">
      <!-- Name Field -->
      <div>
        <label class="block text-sm font-medium text-slate-300 mb-2">Full Name *</label>
        <input
          v-model="form.name"
          type="text"
          required
          class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors"
          placeholder="Your full name"
        />
      </div>
      
      <!-- Email Field -->
      <div>
        <label class="block text-sm font-medium text-slate-300 mb-2">Email Address *</label>
        <input
          v-model="form.email"
          type="email"
          required
          class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors"
          placeholder="your.email@example.com"
        />
      </div>
    </div>
    
    <!-- Subject Field -->
    <div>
      <label class="block text-sm font-medium text-slate-300 mb-2">Subject *</label>
      <input
        v-model="form.subject"
        type="text"
        required
        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors"
        placeholder="Project discussion, job opportunity, etc."
      />
    </div>
    
    <!-- Message Field -->
    <div>
      <label class="block text-sm font-medium text-slate-300 mb-2">Message *</label>
      <textarea
        v-model="form.message"
        rows="6"
        required
        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors resize-none"
        placeholder="Tell me about your project, requirements, timeline, budget, etc."
      ></textarea>
    </div>
    
    <!-- Submit Button -->
    <div class="flex justify-center">
      <button
        type="submit"
        :disabled="isSubmitting"
        class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
      >
        <span v-if="!isSubmitting">Send Message</span>
        <span v-else class="flex items-center">
          <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Sending...
        </span>
      </button>
    </div>
  </form>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'

const isSubmitting = ref(false)

const form = reactive({
  name: '',
  email: '',
  subject: '',
  message: ''
})

const submitForm = async () => {
  isSubmitting.value = true
  
  // Simulate form submission
  try {
    await new Promise(resolve => setTimeout(resolve, 2000))
    
    // Here you would typically send the form data to your backend
    console.log('Form submitted:', form)
    
    // Reset form
    Object.keys(form).forEach(key => {
      form[key as keyof typeof form] = ''
    })
    
    // Show success message (you might want to use a toast/notification system)
    alert('Message sent successfully! I will get back to you soon.')
    
  } catch (error) {
    console.error('Error submitting form:', error)
    alert('There was an error sending your message. Please try again.')
  } finally {
    isSubmitting.value = false
  }
}
</script>