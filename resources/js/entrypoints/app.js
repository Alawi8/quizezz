import { createApp } from 'vue'
import App from './App.vue'
import Router from "@/entrypoints/src/router.js";


createApp(App).use(Router).mount('#app')
