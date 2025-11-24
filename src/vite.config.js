import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/css/a.css",
        "resources/css/b.css",
        "resources/css/c.css",
        "resources/css/app.css",
      ],
      refresh: true,
    }),
  ],
  server: {
    cors: true,
  },
});
