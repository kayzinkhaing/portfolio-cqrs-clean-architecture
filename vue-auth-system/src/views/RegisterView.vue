<template>
  <div class="register-page">
    <h2>Register</h2>
    <form @submit.prevent="handleRegister">
      <input type="text" v-model="name" placeholder="Name" required />
      <input type="email" v-model="email" placeholder="Email" required />
      <input
        type="password"
        v-model="password"
        placeholder="Password"
        required
      />
      <input
        type="password"
        v-model="passwordConfirmation"
        placeholder="Confirm Password"
        required
      />
      <button type="submit">Register</button>
    </form>

    <p
      v-if="message"
      :class="{ 'error-message': isError, 'success-message': !isError }"
    >
      {{ message }}
    </p>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";

const name = ref("");
const email = ref("");
const password = ref("");
const passwordConfirmation = ref("");
const message = ref("");
const isError = ref(false);

const handleRegister = async () => {
  message.value = "";
  isError.value = false;

  try {
    const response = await axios.post("http://127.0.0.1:8000/api/register", {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: passwordConfirmation.value,
    });
    message.value = "Registered successfully!";
    isError.value = false;

    // Optionally, clear form
    name.value = "";
    email.value = "";
    password.value = "";
    passwordConfirmation.value = "";
  } catch (err) {
    isError.value = true;
    if (err.response && err.response.status === 422) {
      const errors = err.response.data.errors;
      message.value = Object.values(errors).flat().join("\n");
    } else {
      message.value = err.message || "Registration failed.";
    }
  }
};
</script>

<style scoped>
.register-page {
  max-width: 400px;
  margin: 50px auto;
  padding: 25px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-family: Arial, sans-serif;
}

input {
  display: block;
  width: 100%;
  margin-bottom: 12px;
  padding: 10px;
  box-sizing: border-box;
  border: 1px solid #aaa;
  border-radius: 3px;
  font-size: 1rem;
}

input:focus {
  outline: none;
  border-color: #3498db;
  box-shadow: 0 0 5px #3498db;
}

button {
  padding: 10px 15px;
  background-color: #3498db;
  color: white;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #2980b9;
}

.error-message {
  color: #e74c3c;
  white-space: pre-line; /* to show new lines in alert */
  margin-top: 10px;
}

.success-message {
  color: #27ae60;
  margin-top: 10px;
}
</style>
