window.Vue = require('vue');

Vue.component('add-to-cart', require('./components/addToCart').default);

window.addEventListener('load', ()  => {
	const app = new Vue({
		el: "#app"
	});
});
