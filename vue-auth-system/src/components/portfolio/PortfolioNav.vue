<template>
  <header
    class="sticky top-0 z-50 bg-gray-900 border-b border-gray-800 backdrop-blur-sm bg-opacity-90"
  >
    <!-- <nav class="container mx-auto px-4 py-3 flex justify-between items-center" ref="navRef"> -->
    <nav
      class="container mx-auto px-8 lg:px-20 xl:px-32 py-3 flex justify-between items-center"
      ref="navRef"
    >
      <!-- Logo -->
      <router-link to="/portfolio" class="flex items-center space-x-3 group">
        <div
          class="w-10 h-10 rounded-full overflow-hidden border-2 border-purple-500/30 group-hover:border-purple-400 transition-all duration-300"
        >
        
        <img
        src="/images/profile1.avif"
        alt="Kay Zin Khaing"
        width="80"
        height="80"
        loading="eager"
        decoding="async"
        class="w-full h-full object-cover"
        />
        
        <!-- <img
          src="@/assets/images/profile1.avif"
          alt="Kay Zin Khaing"
          class="w-full h-full object-cover"
          loading="lazy"
          onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'"
        /> -->
          <div
            class="w-full h-full bg-gradient-to-br from-purple-600 to-pink-500 hidden items-center justify-center text-white font-bold text-sm"
          >
            KZ
          </div>
        </div>
        <div>
          <h1
            class="text-lg font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent"
          >
            Kay Zin Khaing
          </h1>
          <p
            class="text-xs text-gray-400 group-hover:text-gray-300 transition-colors"
          >
            Full-Stack Developer
          </p>
        </div>
      </router-link>

      <!-- Desktop Nav -->
      <ul class="hidden md:flex items-center space-x-6">
        <li v-for="link in links" :key="link.path">
          <router-link
            :to="link.path"
            :class="[
              'text-gray-300 hover:text-white transition-colors duration-200 font-medium text-sm relative',
              isActive(link.path) ? 'text-white' : '',
            ]"
          >
            {{ link.name }}
            <span
              v-if="isActive(link.path)"
              class="absolute -bottom-1 left-0 w-full h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full"
            ></span>
          </router-link>
        </li>
      </ul>

      <!-- Mobile Toggle -->
      <button
        @click.stop="toggleMobileMenu"
        class="md:hidden relative w-8 h-8 flex flex-col items-center justify-center transition-all duration-300"
      >
        <span
          class="block w-6 h-0.5 bg-white rounded-full mb-1 transition-all duration-300"
        ></span>
        <span
          class="block w-6 h-0.5 bg-white rounded-full mb-1 transition-all duration-300"
        ></span>
        <span
          class="block w-6 h-0.5 bg-white rounded-full transition-all duration-300"
        ></span>
      </button>

      <!-- Mobile Menu -->
      <div
        v-if="isMobileMenuOpen"
        class="fixed inset-0 z-40 md:hidden"
        ref="mobileMenuRef"
      >
        <!-- Backdrop -->
        <div
          class="absolute inset-0 bg-black bg-opacity-70 backdrop-blur-sm transition-opacity duration-300"
          @click="closeMobileMenu"
        ></div>

        <!-- Menu Content -->
        <div
          class="absolute inset-0 bg-gray-900 transform transition-transform duration-300 ease-out overflow-y-auto"
        >
          <div class="container mx-auto px-6 py-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-12">
              <div class="flex items-center space-x-4">
                <div
                  class="w-14 h-14 rounded-full bg-gradient-to-br from-purple-600 to-pink-500 flex items-center justify-center text-white font-bold text-lg"
                >
                  KZ
                </div>
                <div>
                  <h2 class="text-white font-bold text-xl">Kay Zin Khaing</h2>
                  <p class="text-gray-400 text-sm">Full-Stack Developer</p>
                </div>
              </div>
              <button
                @click="closeMobileMenu"
                class="text-gray-400 hover:text-white transition-colors"
              >
                <svg
                  class="w-6 h-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  ></path>
                </svg>
              </button>
            </div>

            <!-- Navigation Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-12">
              <router-link
                v-for="link in links"
                :key="link.path"
                :to="link.path"
                @click="closeMobileMenu"
                :class="[
                  'group p-6 rounded-2xl border-2 transition-all duration-300 hover:scale-105 hover:shadow-xl flex flex-col items-center justify-center text-center',
                  isActive(link.path)
                    ? 'bg-gradient-to-br from-purple-500/10 to-pink-500/10 border-purple-500/50 shadow-lg'
                    : 'bg-gray-800/50 border-gray-700 hover:border-purple-500/30 hover:bg-gray-800',
                ]"
              >
                <div
                  class="w-12 h-12 rounded-xl mb-3 flex items-center justify-center transition-all duration-300"
                  :class="
                    isActive(link.path)
                      ? 'bg-gradient-to-br from-purple-500 to-pink-500 text-white'
                      : 'bg-gray-700 group-hover:bg-purple-500/20 text-gray-300 group-hover:text-white'
                  "
                >
                  <span class="font-bold text-lg">{{
                    getIcon(link.name)
                  }}</span>
                </div>
                <span class="font-semibold text-white text-lg mb-1">{{
                  link.name
                }}</span>
                <p
                  class="text-gray-400 text-sm group-hover:text-gray-300 transition-colors"
                >
                  {{ getDescription(link.name) }}
                </p>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const isMobileMenuOpen = ref(false);
const navRef = ref(null);
const mobileMenuRef = ref(null);

const links = [
  { name: "Home", path: "/portfolio" },
  { name: "About", path: "/portfolio/about" },
  { name: "Skills", path: "/portfolio/skills" },
  { name: "Education", path: "/portfolio/education" },
  { name: "Work", path: "/portfolio/work" },
  { name: "Experience", path: "/portfolio/experience" },
  { name: "Technologies", path: "/portfolio/site-technologies" },
  { name: "Hire Me", path: "/portfolio/hire-me" },
];

const getIcon = (name) => {
  const icons = {
    Home: "🏠",
    About: "👤",
    Skills: "⚡",
    Education: "🎓",
    Work: "💼",
    Experience: "🚀",
    Technologies: "🛠️",
    "Hire Me": "💝",
  };
  return icons[name] || "📄";
};

const getDescription = (name) => {
  const descriptions = {
    Home: "Welcome page",
    About: "My background",
    Skills: "Technical abilities",
    Education: "Academic journey",
    Work: "Projects & portfolio",
    Experience: "Career timeline",
    Technologies: "Tools & stack",
    "Hire Me": "Ready to work together?",
  };
  return descriptions[name] || "Learn more";
};

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const closeMobileMenu = () => {
  isMobileMenuOpen.value = false;
};

const handleClickOutside = (event) => {
  if (
    navRef.value &&
    !navRef.value.contains(event.target) &&
    mobileMenuRef.value &&
    !mobileMenuRef.value.contains(event.target)
  ) {
    closeMobileMenu();
  }
};

const isActive = (path) => {
  return route.path === path;
};

onMounted(() => {
  document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside);
});
</script>
