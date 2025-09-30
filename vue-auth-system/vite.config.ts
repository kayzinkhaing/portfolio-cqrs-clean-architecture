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
      host: true, // allow connections from any host
      strictPort: true,
      open: false, // don’t open browser automatically in Docker
      hmr: {
        overlay: true,
      },
      allowedHosts: ['www.kayzinkhine.com', 'kayzinkhine.com', 'localhost', 'portfolio-vue-1'],
    },

    build: {
      target: 'esnext',
      outDir: 'dist',
      sourcemap: !isProduction,
      rollupOptions: {
        output: {
          manualChunks(id) {
            if (id.includes('node_modules')) return 'vendor'
            if (id.includes('/api/commands/')) return 'commands'
            if (id.includes('/api/queries/')) return 'queries'
          },
        },
      },
    },

    define: {
      __DEV__: !isProduction,
      __API_BASE__: JSON.stringify(
        isProduction
          ? 'http://www.kayzinkhine.com'  // production backend
          : 'http://localhost'            // local backend
      ),
    },

    test: {
      globals: true,
      environment: 'jsdom',
      setupFiles: './tests/setup.ts',
      include: ['src/**/*.{test,spec}.{ts,tsx}'],
      coverage: {
        provider: 'v8',
        reporter: ['text', 'html', 'lcov'],
        reportsDirectory: './coverage',
        all: true,
        include: ['src/**/*.{ts,vue}'],
        exclude: ['src/main.ts', '**/__tests__/**'],
      },
    },
  }
})
