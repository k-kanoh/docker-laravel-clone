import path from "path";
import react from "@vitejs/plugin-react-swc";
import laravel from "laravel-vite-plugin";
import { defineConfig } from "vite";

export default defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/js/app.js",
        "resources/css/app.css",
        "frontend/main.css",
        "frontend/main.tsx",
      ],
      refresh: true,
    }),
    react(),
  ],
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "frontend"),
    },
  },
});
