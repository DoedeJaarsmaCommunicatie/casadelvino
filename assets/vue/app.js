window.Vue = require('vue');

Vue.component('add-to-cart', require('./components/addToCart'));

window.addEventListener('load', ()  => {
	const app = new Vue({
		el: "#app"
	});
});
