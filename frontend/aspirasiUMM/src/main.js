//import createApp from Vue 
import { createApp } from 'vue'; 
//import component App 
import App from './App.vue'; 
//import config router 
import router from './router' 


import './assets/css/style.css';
import './assets/css/bootstrap.css';
import './assets/css/responsive.css';
import './assets/css/font-awesome.min.css';
import './assets/css/login.css';
import './assets/css/dashboard.css';
import './assets/css/style.min.css';
import 'owl.carousel';
import '../public/js/bootstrap.js';
import 'owl.carousel/dist/assets/owl.carousel.css';
import 'owl.carousel/dist/assets/owl.theme.default.css'
import '@fortawesome/fontawesome-free/css/all.css'



const app = createApp(App); 
 
//gunakan "router" di Vue dengan plugin "use" 
app.use(router); 
 
app.mount('#app'); 
