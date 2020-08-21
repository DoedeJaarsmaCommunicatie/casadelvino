/* eslint-disable */
import Vue from 'vue';
import store from './store/store';
const axios = require('axios');
const _ = require('lodash');

Vue.component('kiyoh-reviews', require('./views/KiyohReviews').default);
Vue.component('cdv-filter', require('./views/Filter').default);
Vue.component('cdv-mobile-cart', require('./views/MobileCartPopup').default);
Vue.component('add-to-cart',  require('./views/addToCart').default);

Vue.prototype.$http = axios;
Vue.prototype.$_ = _;

new Vue({
	store
}).$mount('#app');
