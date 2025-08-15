<template>
  <div class="space-y-4">
    <p class="text-gray-700 text-lg font-medium">
      Scan the QR code with your Authenticator app
    </p>
    <div class="flex justify-center">
      <div class="p-4 border rounded-xl bg-gray-50 shadow-inner" v-html="qr"></div>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{ qr: string }>()
</script>
