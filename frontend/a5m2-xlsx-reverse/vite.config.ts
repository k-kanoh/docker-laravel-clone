import react from "@vitejs/plugin-react-swc";
import { defineConfig } from "vite";

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  base: "/a5xlsxrev/",
  build: {
    outDir: "../../src/public/a5xlsxrev",
    emptyOutDir: true,
  },
});
