import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [

        laravel({

            input: [
                "resources/css/app.css",
                "resources/js/entrypoints/app.js",
                "resources/js/composable/app.js",
                "resources/js/quizezz-env/app.js",
                "resources/js/admin/app.js"
            ],
            refresh: true,
            build: {
                sourcemap: true
            },
        }),
        vue(),
    ],
});
