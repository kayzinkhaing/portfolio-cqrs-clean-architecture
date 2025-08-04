import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/HomeView.vue";
import Register from "../views/RegisterView.vue";
import Login from "../views/LoginView.vue";
import Logout from "../views/LogoutView.vue";

const routes = [
  { path: "/", name: "Home", component: Home },
  { path: "/register", name: "Register", component: Register },
  { path: "/login", name: "Login", component: Login },
  { path: "/logout", name: "Logout", component: Logout },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
