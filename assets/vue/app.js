/* eslint-disable */
// TODO: Implement Vuex for better state management.
// window.Vue = require('vue');
import Vue from 'vue';
import store from './store/store';
const axios = require('axios');
const _ = require('lodash');


Vue.config.productionTip = false;

Vue.component('add-to-cart',  require('./views/addToCart').default);
Vue.component('kiyoh-reviews', require('./views/KiyohReviews').default);
Vue.component('cdv-filter', require('./views/Filter').default);
Vue.component('cdv-shopping-cart', require('./views/ShoppingCartPopup').default);
//
// Vue.component('cdv-shopping-cart', () => import( /* webpackChunkName: "dist/js/ShoppingCart" */'./views/ShoppingCartPopup'));

Vue.prototype.$http = axios;
Vue.prototype.$http.defaults.baseURL = 'https://casadelvino.nl/';
Vue.prototype.$_ = _;


window.addEventListener('load', ()  => {
	const app = new Vue({
		store
	}).$mount('#app');
});
