import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia'; //Pinia vai gerenciar o estado da aplicação
import router from './router';
import App from './App.vue';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Criar app Vue
const appElement = document.getElementById('app');
if (appElement) {
    const app = createApp(App);
    app.use(createPinia());
    app.use(router);
    app.mount('#app');
}
