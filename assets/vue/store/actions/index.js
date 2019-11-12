import axios from 'axios';

// axios.defaults.baseURL = 'https://casadelvino.lndo.site/';
axios.defaults.baseURL = process.env.NODE_ENV === 'production'
  ? 'https://casadelvino.nl/'
  : 'https://casadelvino.lndo.site';

export default {
  get_cart({ commit }) {
    return new Promise((resolve, reject) => {
      commit('fetch_cart');
      axios.get('/wp-admin/admin-ajax.php?action=get_cart_contents')
        .then((res) => {
          commit('fetch_cart_success', res.data.data);
          resolve(res);
        })
        .catch((err) => {
          commit('fetch_cart_error');
          reject(err);
        });
    });
  },
  update_cart({ commit }, data) {
    return new Promise((resolve, reject) => {
      commit('update_cart');
      axios.post('/wp-admin/admin-ajax.php/?action=update_cart', data)
        .then((res) => {
          commit('update_cart_success');
          resolve(res);
        })
        .catch((err) => {
          commit('update_cart_error');
          reject(err);
        });
    });
  },
  add_to_cart({ commit }, data) {
    return new Promise((resolve, reject) => {
      commit('add_to_cart');
      axios.post('/wp-admin/admin-ajax.php/?action=add_to_cart', data)
        .then((res) => {
          commit('add_to_cart_success');
          resolve(res);
        })
        .catch((err) => {
          commit('add_to_cart_error');
          reject(err);
        });
    });
  },
  check_stock({ commit }, productId) {
    return new Promise((resolve, reject) => {
      commit('check_stock');
      axios.get(`/wp-json/casa/v1/stock/${productId}`)
        .then((res) => {
          commit('check_stock_success');
          resolve(res);
        })
        .catch((err) => {
          commit('check_stock_error');
          reject(err);
        });
    });
  },
};
