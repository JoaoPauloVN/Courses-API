import './bootstrap';
import '../css/app.css';

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { createPinia } from 'pinia';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import VueTheMask from 'vue-the-mask';
import money from 'v-money';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const pinia = createPinia()

axios.defaults.withCredentials = true;
axios.defaults.headers.common['Accept'] = "application/json";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(pinia)
            .use(VueTheMask)
            .use(money, {precision: 2})
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
