import './bootstrap';
import {createApp} from 'vue'

// Import Bootstrap
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"

import App from './app.vue'

// Plugins
import { registerHelper } from './helper'
import { registerPlugins } from './plugins'

const app = createApp(App)

app.config.globalProperties.baseUrl = import.meta.env.VITE_APP_URL
app.config.globalProperties.recapcha_site_key = import.meta.env.VITE_RECAPTCHAV2_SITEKEY

app.use(registerPlugins)
app.use(registerHelper)
app.mount('#app')