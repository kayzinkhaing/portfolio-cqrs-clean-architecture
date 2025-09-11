import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'
import tsconfigPaths from 'vite-tsconfig-paths'

export default defineConfig(({ mode }) => {
  const isProduction = mode === 'production'

  return {
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
      open: true,
      strictPort: true,
      hmr: { overlay: true },
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
        isProduction ? 'https://api.example.com' : 'http://localhost:8000'
      ),
    },

    test: {
      globals: true,
      environment: 'jsdom',
      setupFiles: './tests/setup.ts', // setup for global mocks
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
