'use strict';
import axios from 'axios';

axios.defaults.baseURL = 'https://casadelvino.nl/';

export default {
	get_cart({ commit }) {
		return new Promise((resolve, reject) => {
			commit('fetch_cart');
			axios.get('wp-admin/admin-ajax.php?action=get_cart_contents')
				.then((res)=> {
					commit('fetch_cart_success', res.data.data);
					resolve(res)
				})
				.catch((err) => {
					commit('fetch_cart_error');
					reject(err);
				});
		});
	},
	update_cart({commit}, data) {
		return new Promise((resolve, reject) => {
			commit('update_cart');
			axios.post('wp-admin/admin-ajax.php/?action=update_cart', data)
				.then((res) => {
					commit('update_cart_success');
					resolve(res)
				})
				.catch(err => {
					commit('update_cart_error');
					reject(err)
				});
		});
	},
}
