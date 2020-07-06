
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue'
import VModal from 'vue-js-modal'
import {routes} from './router';

Vue.use(BootstrapVue)
Vue.use(VModal, { dialog: true})
// init vue js router
Vue.use(VueRouter);
const router = new VueRouter({ 
	routes : routes
});

// init vue js
const app = new Vue({
  router
}).$mount('#app');