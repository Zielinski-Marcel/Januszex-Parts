import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import { networkInterfaces } from 'os'

export default ({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');
    return defineConfig({
        plugins: [
            laravel({
                input: 'resources/js/app.jsx',
                refresh: true,
            }),
            react(),
        ],
        server: {
            hmr: {
                host: 'localhost',
            },
            host: true,
            port: env.VITE_PORT,
        },
    })
}
