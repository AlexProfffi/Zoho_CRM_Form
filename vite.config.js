import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';


export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [
                'app/**',
                'resources/views/**',
                'routes/**',
                'config/**'
            ],
        })
    ],
    server: {
        host: 'localhost',
        port: 3000
    },
    resolve: {
        alias: {
            '@': '/resources/js',
            'ziggy': 'vendor/tightenco/ziggy/dist/vue.es.js'
        }
    }
});
