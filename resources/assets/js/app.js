import Vue from 'vue';
import VueResource from 'vue-resource';
import VueRouter from 'vue-router';
import $ from 'jquery';
var jQuery = require('jquery');
window.$ = window.jQuery = jQuery;
require('bootstrap');
require('fontawesome');
Vue.use(VueRouter);
Vue.use(VueResource);

export default Vue;

import App from './components/App.vue';
import Register from './components/Register.vue';
import Product from './components/Product.vue';
import Login from './components/Login.vue';

Vue.http.headers.common['X-CSRF-TOKEN'] = document.getElementsByName('csrf-token')[0].getAttribute('content');
Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('id_token');
Vue.http.options.root = 'http://localhost:8000';

//require('./bootstrap');

const routes = [
	{path: '/register', alias: 'register', component: Register},
	{path: '/product', alias: 'product', component: Product},
	{path: '/', alias: '/', component: Login},
]
export const router = new VueRouter({routes});

const app = new Vue({
	router,
    el: '#app',
    render: h => h(App)
});
