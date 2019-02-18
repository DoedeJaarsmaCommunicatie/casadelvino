/* eslint-disable */
// window.Vue = require('vue');
import Vue from 'vue';
const axios = require('axios');
const _ = require('underscore');

Vue.component('add-to-cart',  require('./views/addToCart').default);
Vue.component('kiyoh-reviews', require('./views/KiyohReviews').default);
Vue.component('cdv-filter', require('./views/Filter').default);
Vue.component('cdv-shopping-cart', require('./views/ShoppingCartPopup').default);


Vue.prototype.$http = axios;
Vue.prototype.$http.defaults.baseURL = 'https://casadelvino.nl/';
Vue.prototype.$_ = _;


window.addEventListener('load', ()  => {
	const app = new Vue({
	}).$mount('#app');

	const footer = new Vue().$mount('#footerApp');
});
