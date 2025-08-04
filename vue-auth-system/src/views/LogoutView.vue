<template>
  <div class="logout-container">
    <h2>Logout</h2>

    <button @click="logoutUser" class="btn">Logout</button>

    <p v-if="message" class="message">{{ message }}</p>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const message = ref("");

const logoutUser = () => {
  // Clear localStorage
  localStorage.removeItem("token");
  localStorage.removeItem("user");

  message.value = "You have been logged out successfully.";

  // Redirect after 1.5s
  setTimeout(() => {
    router.push("/login");
  }, 1500);
};
</script>

<style>
.logout-container {
  max-width: 400px;
  margin: 50px auto;
  padding: 30px;
  border: 1px solid #ccc;
  border-radius: 6px;
  box-shadow: 0 0 10px #ccc;
  text-align: center;
}

h2 {
  margin-bottom: 20px;
}

.btn {
  padding: 10px 20px;
  background-color: #f44336;
  color: white;
  font-weight: bold;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.btn:hover {
  background-color: #d32f2f;
}

.message {
  margin-top: 15px;
  color: green;
  font-weight: bold;
}
</style>
