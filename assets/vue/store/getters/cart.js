import * as _ from 'lodash';

export default {
	hasCartItems: state => !!_.size(state.cart),
	cartCount: state => {
		let total = 0;
		_.forOwn(state.cart, (value, key) => {
			total += value.quantity
		});
		return total
	},
	cart: state => state.cart,
	totalPrice: state => {
		let total = 0;
		_.forOwn(state.cart, (value, key) => {
			total += (value.quantity*value.price)
		})
		return total.toFixed(2);
	}
}
