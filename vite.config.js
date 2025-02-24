import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        proxy: {
            '/': {
                target: 'http://eatikaf.test', // Proxy to your Laravel server
                changeOrigin: true,
            },
        },
        cors: {
            origin: 'http://eatikaf.test', // Allow cross-origin requests from your site
            methods: ['GET', 'POST'],
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
            ],
        }),
    ],
});
