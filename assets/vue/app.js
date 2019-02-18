/* eslint-disable */
// window.Vue = require('vue');
import Vue from 'vue';
const axios = require('axios');

Vue.component('add-to-cart',  require('./views/addToCart').default);
Vue.component('kiyoh-reviews', require('./views/KiyohReviews').default);
Vue.component('cdv-filter', require('./views/Filter').default);


Vue.prototype.$http = axios;
Vue.prototype.$http.defaults.baseURL = 'https://casadelvino.nl/';

window.addEventListener('load', ()  => {
	const app = new Vue({
	}).$mount('#app');
});
