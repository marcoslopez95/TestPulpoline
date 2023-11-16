import './styles/app.css';
import './styles/app.css';
import 'vuetify/styles'
import "vue-toastification/dist/index.css";
import '@mdi/font/css/materialdesignicons.css'
import {createApp} from 'vue';
import { vuetify } from './vuetifty'
import Register from '@/Register.vue';
import Home from '@/Home.vue'
import Header from '@/Header.vue'
import Login from '@/Login.vue'
import Toast from "vue-toastification";

const app = createApp();
const options = {};
app
.use(Toast, options)
.use(vuetify)
.component('Register',Register)
.component('Home',Home)
.component('Login',Login)
.component('header-v',Header)
.mount("#app");