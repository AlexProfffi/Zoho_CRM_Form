
import {createApp, h} from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { ZiggyVue } from 'ziggy'

import PrimeVue from 'primevue/config'
import ToastService from 'primevue/toastservice';
import 'primevue/resources/themes/lara-light-blue/theme.css'


createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {

        const app = createApp({ render: () => h(App, props),
            setup() {
            }
        })

        app.use(plugin)
            .use(PrimeVue)
            .use(ToastService)
            .use(ZiggyVue)
            .mount(el)
    },
})

