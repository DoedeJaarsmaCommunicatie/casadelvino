window.Vue = require('vue');
const axios = require('axios');

Vue.component('add-to-cart', require('./components/addToCart').default);
Vue.component('cdv-search', require('./components/SearchComponent').default);

Vue.prototype.$http = axios;
Vue.prototype.$http.defaults.baseURL = 'https://casadelvino.nl/';

window.addEventListener('load', ()  => {
	const app = new Vue({
		el: "#app"
	});
});
