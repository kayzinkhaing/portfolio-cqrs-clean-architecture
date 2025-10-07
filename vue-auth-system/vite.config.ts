import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'
import tsconfigPaths from 'vite-tsconfig-paths'

export default defineConfig(({ mode }) => {
  const isProduction = mode === 'production'

  return {
    base: isProduction ? '/portfolio/' : '/',
    plugins: [
      vue(),
      tsconfigPaths(),
    ],

    resolve: {
      alias: {
        '@': path.resolve(__dirname, 'src'),
        '@api': path.resolve(__dirname, 'src/api'),
        '@commands': path.resolve(__dirname, 'src/api/commands'),
        '@queries': path.resolve(__dirname, 'src/api/queries'),
        '@stores': path.resolve(__dirname, 'src/stores'),
        '@composables': path.resolve(__dirname, 'src/composables'),
        '@utils': path.resolve(__dirname, 'src/utils'),
        '@assets': path.resolve(__dirname, 'src/assets'),
      },
    },

    server: {
      port: 5173,
      host: true,
      strictPort: true,
      hmr: { overlay: true },
      allowedHosts: ['www.kayzinkhine.com', 'kayzinkhine.com', 'localhost', 'portfolio-vue-1'],
    },

    build: {
  target: 'esnext',
  minify: 'esbuild',       // already fast
  cssCodeSplit: true,      // split CSS
  rollupOptions: {
    output: {
      manualChunks(id) {
        if (id.includes('node_modules')) return 'vendor'
        if (id.includes('vue-router')) return 'vue-router'
        if (id.includes('pinia')) return 'pinia'
        if (id.includes('@apollo')) return 'apollo'
        if (id.includes('/pages/Portfolio/')) return 'portfolio'
        if (id.includes('/pages/Dashboard/')) return 'dashboard'
      }
    }
  }
}
,

    define: {
      __DEV__: !isProduction,
      __API_BASE__: JSON.stringify(
        isProduction
          ? 'https://www.kayzinkhine.com'
          : 'http://localhost'
      ),
    },
  }
})
