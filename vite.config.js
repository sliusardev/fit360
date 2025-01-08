import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 'resources/js/app.js',
                'resources/views/themes/simple-gray/assets/simple-gray.css',
                'resources/views/themes/simple-gray/assets/simple-gray.js',
            ],
            refresh: true,
        }),
    ],
});
