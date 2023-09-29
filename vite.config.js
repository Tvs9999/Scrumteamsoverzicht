import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue'; 
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler.js'
        }
    },
    plugins: [
        vue(),
        laravel({
            input: ['resources/scss/app.scss', 'resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ], build: { outDir: 'public/js', }, 
    server: {
        port: 3000,
        // Disable Vue template compilation
    },
});
