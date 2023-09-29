import { defineConfig } from 'vite';
import Vue from '@vitejs/plugin-vue'; 
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler.js'
        }
    },
    plugins: [
        Vue(),
        laravel({
            input: ['resources/scss/app.scss', 'resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ], build: { outDir: 'public/js', }, 
    server: {
        port: 3000,
        // Disable Vue template compilation
    },
});
