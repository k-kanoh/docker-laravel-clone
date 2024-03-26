import React from "react";
import ReactDOM from "react-dom/client";

import { Layout } from "./Layout";
import { ThemeProvider } from "./components/DarkMode/theme-provider";
import "./main.css";

ReactDOM.createRoot(document.getElementById("root")!).render(
  <React.StrictMode>
    <ThemeProvider defaultTheme="dark" storageKey="vite-ui-theme">
      <Layout />
    </ThemeProvider>
  </React.StrictMode>
);
