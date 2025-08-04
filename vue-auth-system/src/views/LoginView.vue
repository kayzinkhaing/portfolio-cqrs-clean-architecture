<template>
  <div class="login-container">
    <h2>Login</h2>
    <form @submit.prevent="handleLogin">
      <div class="form-group">
        <label>Email:</label>
        <input type="email" v-model="email" required />
      </div>

      <div class="form-group">
        <label>Password:</label>
        <input type="password" v-model="password" required />
      </div>

      <button type="submit" :disabled="loading">
        {{ loading ? "Logging in..." : "Login" }}
      </button>

      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
      <p v-if="successMessage" class="success">{{ successMessage }}</p>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const email = ref("");
const password = ref("");
const errorMessage = ref("");
const successMessage = ref("");
const loading = ref(false);

const router = useRouter();

const handleLogin = async () => {
  errorMessage.value = "";
  successMessage.value = "";
  loading.value = true;

  try {
    const response = await axios.post("http://127.0.0.1:8000/api/login", {
      email: email.value,
      password: password.value,
    });

    if (response.data.success) {
      localStorage.setItem("token", response.data.data.token);
      successMessage.value = "Login successful!";
      setTimeout(() => {
        router.push("/logout"); // go to logout or home page
      }, 5000);
    }
  } catch (error) {
    errorMessage.value =
      error.response?.data?.message || "Login failed. Please try again.";
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.login-container {
  max-width: 400px;
  margin: 60px auto;
  padding: 30px;
  border: 1px solid #ccc;
  border-radius: 6px;
  background-color: #f9f9f9;
}

h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

.form-group {
  margin-bottom: 16px;
}

label {
  display: block;
  margin-bottom: 6px;
  font-weight: bold;
  color: #444;
}

input {
  width: 100%;
  padding: 8px 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  width: 100%;
  padding: 10px 0;
  background-color: #007bff;
  color: white;
  border: none;
  font-size: 16px;
  border-radius: 4px;
  cursor: pointer;
}

button:disabled {
  background-color: #888;
  cursor: not-allowed;
}

.error {
  color: red;
  margin-top: 10px;
  text-align: center;
}

.success {
  color: green;
  margin-top: 10px;
  text-align: center;
}
</style>
