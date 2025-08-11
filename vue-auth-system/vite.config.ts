/// <reference types="node" />

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'
import tsconfigPaths from 'vite-tsconfig-paths'  // <-- new import

export default defineConfig({
  plugins: [
    vue(),
    tsconfigPaths(), // <-- add this plugin here
  ],
  resolve: {
    alias: [
      { find: '@', replacement: path.resolve(__dirname, 'src') },
    ],
  }
})
