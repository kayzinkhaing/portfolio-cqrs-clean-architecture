<template>
  <form @submit.prevent="onSubmit">
    <slot></slot>
    <button
      type="submit"
      class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md"
    >
      {{ buttonText }}
    </button>
  </form>
</template>

<script setup>
defineProps({
  onSubmit: Function,
  buttonText: String,
})
</script>
