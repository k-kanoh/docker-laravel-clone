import path from "path";
import react from "@vitejs/plugin-react-swc";
import { defineConfig } from "vite";

export default defineConfig({
  plugins: [react()],
  build: {
    outDir: "../../src/public/genbuild",
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: "src/main.tsx",
    },
  },
  server: {
    proxy: {
      "/api": {
        target: "http://192.168.0.99",
        changeOrigin: true,
      },
    },
  },
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "./src"),
    },
  },
});
