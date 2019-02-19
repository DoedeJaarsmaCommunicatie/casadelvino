'use strict';
import Vue from 'vue';
import Vuex from 'vuex';
import actions from './actions/index';
import mutations from './mutations/index';
import getters from './getters/index';
import state from './state/index'


Vue.use(Vuex);

export default new Vuex.Store({
	actions,
	mutations,
	state,
	getters
})
