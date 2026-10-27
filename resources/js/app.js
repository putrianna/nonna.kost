import '../css/app.css'
import './bootstrap'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'

import { createPinia } from 'pinia'
import { useDarkModeStore } from './stores/darkMode'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'
const pinia = createPinia()

createInertiaApp({
  title: (title) => (title ? `${title} - ${appName}` : appName),

  resolve: (name) =>
    resolvePageComponent(`./pages/${name}.vue`, import.meta.glob([
      './pages/**/*.vue',
      // These unused starter-kit screens require a two-factor backend not installed here.
      '!./pages/Auth/TwoFactorChallenge.vue',
      '!./pages/Settings/TwoFactor.vue',
    ])),

  setup({ el, App, props, plugin }) {
    const vueApp = createApp({ render: () => h(App, props) })

    vueApp
      .use(plugin)      // Inertia
      .use(pinia)       // Pinia
      .use(ZiggyVue)    // route() helper in Vue
      .mount(el)

    // init stores after pinia exists
    useDarkModeStore(pinia).init()

    return vueApp
  },

  progress: { color: '#4B5563' },
})
