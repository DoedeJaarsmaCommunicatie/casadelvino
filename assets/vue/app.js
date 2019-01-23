window.Vue = require('vue');

Vue.component('add-to-cart', require('./components/addToCart'));

const app = new Vue({
	el: "#app"
});