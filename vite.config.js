import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import path from "path";
// import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            // input: ["resources/css/app.css", "resources/js/app.js"],
            input: ["resources/js/app.js"],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    includeAbsolute: false,
                },
            },
        }),
        // tailwindcss(),
    ],
    resolve: {
        alias: {
            ziggy: path.resolve("vendor/tightenco/ziggy/dist/index.esm.js"),
        },
    },
});
