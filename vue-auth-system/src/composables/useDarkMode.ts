import { ref, onMounted } from 'vue'

export const useDarkMode = () => {
  const isDark = ref(true)

  const toggleDarkMode = () => {
    isDark.value = !isDark.value
    updateDarkModeClass()
    // Note: localStorage usage removed for Claude.ai compatibility
  }

  const updateDarkModeClass = () => {
    if (isDark.value) {
      document.documentElement.classList.add('dark')
    } else {
      document.documentElement.classList.remove('dark')
    }
  }

  const initializeDarkMode = () => {
    // Default to dark mode
    isDark.value = true
    updateDarkModeClass()
  }

  onMounted(() => {
    initializeDarkMode()
  })

  return {
    isDark,
    toggleDarkMode
  }
}