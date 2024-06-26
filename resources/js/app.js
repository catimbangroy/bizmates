import "./bootstrap";
import "bootstrap";
import router from "./router";

import App from "./App.vue";

import Vue, { createApp } from '@vue/compat';
import BootstrapVue from 'bootstrap-vue';
// import HelloBootstrap from './components/HelloBootstrap.vue';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

Vue.use(BootstrapVue);

createApp(App).use(router).mount("#app");
