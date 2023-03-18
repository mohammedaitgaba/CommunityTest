import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from './Router'
import Toaster from "@meforma/vue-toaster";


createApp(App).use(router).use(Toaster).mount('#app')
