import '@/@iconify/icons-bundle'
import App from '@/App.vue'
import vuetify from '@/plugins/vuetify'
import router from '@/router'
import '@core-scss/template/index.scss'
import '@/assets/layouts/styles/index.scss'
import '@styles/styles.scss'
import { createPinia } from 'pinia'
import store from './store'
import { createApp } from 'vue'
import Toast from 'vue-toast-notification'
import 'vue-toast-notification/dist/theme-sugar.css'
import DatePicker from './components/intern/DatePicker.vue'


// Create vue app
const app = createApp(App)


// Use plugins
app.use(vuetify)
app.use(createPinia())
app.component('DatePicker', DatePicker);
app.use(store)
app.use(router)
app.use(Toast)

store.dispatch('initializeStore');

// Mount vue app
app.mount('#app')

// Import and run the axios interceptor code
import '@/others/axios-interceptor'
