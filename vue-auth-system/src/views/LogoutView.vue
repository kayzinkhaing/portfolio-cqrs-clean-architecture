<script setup>
import { onMounted } from "vue";
import { useRouter } from "vue-router";
import { useAuth } from "../composables/useAuth";

const router = useRouter();
const { logout } = useAuth();

onMounted(() => {
  logout();
  router.push("/login"); // Redirect to login after logout
});
</script>

<template>
  <div class="logout-container">
    <h2>You have been logged out.</h2>
    <router-link to="/login">Login again</router-link>
  </div>
</template>
