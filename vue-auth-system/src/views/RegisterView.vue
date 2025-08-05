<template>
  <div class="register-page">
    <div v-if="isLoading" class="loading-container">
      <div class="spinner"></div>
      <p>Loading data, please wait...</p>
    </div>

    <div v-else>
      <h2>Register</h2>
      <form @submit.prevent="handleRegister">
        <input type="text" v-model="name" placeholder="Name" required />
        <input type="email" v-model="email" placeholder="Email" required />
        <input type="password" v-model="password" placeholder="Password" required />
        <input type="password" v-model="passwordConfirmation" placeholder="Confirm Password" required />

        <!-- Township Dropdown -->
        <select v-model="selectedTownshipId" required>
          <option value="">Select Township</option>
          <option v-for="township in townships" :key="township.id" :value="township.id">
            {{ township.name }}
          </option>
        </select>

        <!-- Ward Dropdown -->
        <select v-model="selectedWardId" required>
          <option value="">Select Ward</option>
          <option v-for="ward in filteredWards" :key="ward.id" :value="ward.id">
            {{ ward.name }}
          </option>
        </select>

        <button type="submit">Register</button>
      </form>

      <p v-if="message" :class="{ 'error-message': isError, 'success-message': !isError }">
        {{ message }}
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";

// Form fields
const name = ref("");
const email = ref("");
const password = ref("");
const passwordConfirmation = ref("");

// Dropdown selections
const selectedTownshipId = ref("");
const selectedWardId = ref("");

// Data lists
const townships = ref([]);
const wards = ref([]);

// UI states
const isLoading = ref(true);
const message = ref("");
const isError = ref(false);

// Computed wards based on township
const filteredWards = computed(() => {
  if (!selectedTownshipId.value) return [];
  return wards.value.filter(ward => ward.township_id === Number(selectedTownshipId.value));
});

// Fetch all townships and wards before form load
/*const fetchData = async () => {
  try {
    const [townshipsRes, wardsRes] = await Promise.all([
      axios.get("http://127.0.0.1:8000/api/townships"),
      axios.get("http://127.0.0.1:8000/api/wards")
    ]);
    townships.value = townshipsRes.data;
    wards.value = wardsRes.data;
  } catch (error) {
    console.error("Failed to load data:", error);
  } finally {
    isLoading.value = false;
  }
};*/

const fetchData = async () => {
  try {
    const res = await axios.get("http://127.0.0.1:8000/api/townships");
    townships.value = res.data;
    wards.value = res.data.flatMap(t =>
      t.wards.map(w => ({
        ...w,
        township_id: t.id
      }))
    );
  } catch (error) {
    console.error("Failed to load data:", error);
  } finally {
    isLoading.value = false;
  }
};

const handleRegister = async () => {
  message.value = "";
  isError.value = false;

  try {
    await axios.post("http://127.0.0.1:8000/api/register", {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: passwordConfirmation.value,
      township_id: selectedTownshipId.value,
      ward_id: selectedWardId.value,
    });

    message.value = "Registered successfully!";
    name.value = email.value = password.value = passwordConfirmation.value = "";
    selectedTownshipId.value = selectedWardId.value = "";
  } catch (err) {
    isError.value = true;
    if (err.response?.status === 422) {
      const errors = err.response.data.errors;
      message.value = Object.values(errors).flat().join("\n");
    } else {
      message.value = err.message || "Registration failed.";
    }
  }
};

//onMounted(fetchData);
</script>

<style scoped>
.register-page {
  max-width: 400px;
  margin: 50px auto;
  padding: 25px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-family: Arial, sans-serif;
  background-color: #fff;
}

input,
select {
  display: block;
  width: 100%;
  margin-bottom: 12px;
  padding: 10px;
  box-sizing: border-box;
  border: 1px solid #aaa;
  border-radius: 3px;
  font-size: 1rem;
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
  width: 100%;
}

button:hover {
  background-color: #2980b9;
}

.error-message {
  color: #e74c3c;
  white-space: pre-line;
  margin-top: 10px;
}

.success-message {
  color: #27ae60;
  margin-top: 10px;
}

.loading-container {
  text-align: center;
  padding: 50px;
}

.spinner {
  margin: 0 auto 20px;
  width: 40px;
  height: 40px;
  border: 5px solid #ddd;
  border-top: 5px solid #3498db;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
</style>
