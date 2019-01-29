/* eslint-disable */
window.Vue = require('vue');
const axios = require('axios');

Vue.component('add-to-cart',  require('./views/addToCart').default);
Vue.component('cdv-search', require('./views/SearchComponent').default);
Vue.component('kiyoh-reviews', require('./views/KiyohReviews').default);


Vue.prototype.$http = axios;
Vue.prototype.$http.defaults.baseURL = 'https://casadelvino.nl/';

window.addEventListener('load', ()  => {
	const app = new Vue({
		el: "#app"
	});
});
