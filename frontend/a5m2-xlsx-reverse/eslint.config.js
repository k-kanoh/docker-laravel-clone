import js from "@eslint/js";
import { defineConfig, globalIgnores } from "eslint/config";
import importPlugin from "eslint-plugin-import";
import react from "eslint-plugin-react";
import reactHooks from "eslint-plugin-react-hooks";
import reactRefresh from "eslint-plugin-react-refresh";
import globals from "globals";
import tseslint from "typescript-eslint";

export default defineConfig([
  globalIgnores(["dist"]),
  {
    files: ["**/*.{ts,tsx}"],
    extends: [
      js.configs.recommended,
      tseslint.configs.recommended,
      reactHooks.configs["recommended-latest"],
      reactRefresh.configs.vite,
      react.configs.flat.recommended,
    ],
    plugins: {
      react,
      import: importPlugin,
    },
    languageOptions: {
      ecmaVersion: 2020,
      globals: globals.browser,
    },
    settings: {
      react: {
        version: "detect",
      },
    },
    rules: {
      // React18以降ではReactのインポートは不要
      "react/jsx-uses-react": "off",
      "react/react-in-jsx-scope": "off",

      // anyを許可
      "@typescript-eslint/no-explicit-any": "off",

      // JSXのプロパティを自動ソート
      "react/jsx-sort-props": "warn",

      // インポートの重複を検出
      "import/no-duplicates": "warn",

      // インポートをグループでソート
      "import/order": [
        "warn",
        {
          groups: ["builtin", "external", "parent", "sibling", "index", "object", "type"],
          pathGroups: [
            {
              pattern: "{react,react-dom/**,react-router-dom}",
              group: "builtin",
              position: "before",
            },
            {
              pattern: "@/**",
              group: "parent",
              position: "before",
            },
          ],
          pathGroupsExcludedImportTypes: ["builtin"],
          alphabetize: {
            order: "asc",
          },
          "newlines-between": "never",
        },
      ],
    },
  },
]);
