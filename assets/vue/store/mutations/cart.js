export default {
	fetch_cart(state) {
		state.cart_status = 'loading';
	},
	fetch_cart_success(state, cart) {
		state.cart_status = 'success';
		state.cart = cart;
		state.cart_items = cart.length;
	},
	fetch_cart_error(state) {
		state.cart_status = 'failure';
	},
	update_cart(state) {
		state.cart_status = 'loading';
	},
	update_cart_success(state) {
		state.cart_status = 'success';
	},
	update_cart_error(state) {
		state.cart_status = 'failure';
	},
	add_to_cart(state) {
		state.cart_status = 'loading';
	},
	add_to_cart_success(state) {
		state.cart_status = 'success';
	},
	add_to_cart_error(state) {
		state.cart_status = 'failure';
	}
}
