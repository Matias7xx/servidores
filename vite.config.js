import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
            publicDirectory: 'public',
            buildDirectory: 'build',
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        host: '0.0.0.0', // Permite acesso externo ao container
        port: 5173,      // Porta padrão do Vite
        hmr: {
            port: 5173,
            host: 'localhost', // Para Hot Module Replacement
        },
        watch: {
            usePolling: true, // Necessário para detectar mudanças no Docker
            interval: 1000,   // Intervalo de polling em ms
        },
    },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
    build: {
        chunkSizeWarningLimit: 2000,
        outDir: 'public/build', // Diretório de saída para produção
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
    },
});
