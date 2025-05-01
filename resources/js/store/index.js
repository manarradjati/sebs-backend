import { createStore } from 'vuex';
import axios from 'axios';
import router from '@/router/index';

export default createStore({
  state: {
    data: JSON.parse(localStorage.getItem('data')) || null,
    // Other state properties...
  },
  mutations: {
    setdata(state, data) {
      state.data = data;
      JSON.stringify(localStorage.setItem('data', data));
      localStorage.setItem('data', JSON.stringify(data)); // Corrected line
    },
    cleardata(state) {
      state.data = null;
      localStorage.removeItem('data');
    },
    init(state){
      // console.log(state);
      //commit('resetState');
      state.data=null
      state.data = JSON.parse(localStorage.getItem('data')) || null;
    }
  },
  actions: {
    async login({ commit }, data) {
      return axios.post('/api/login', data)
      .then(response => {
          // console.log(response.data.data)
          commit('setdata', response.data.data);
          commit('init');
          router.push('dashboard');
      })
      .catch(error => {
          console.error(error);
          return Promise.reject(error); // Rethrow the error to handle in components
      });
    },

    async logout({ commit, state }) {
      // console.log('ddd')
      // console.log(state.data.token)
      return axios.post('/api/logout', null, {
          headers: { Authorization: `Bearer ${state.data.token}` },
      })
      .then(() => {
        // console.log('aaaaaaaaaaa');
          commit('cleardata');
          router.push('/login');
      })
      .catch(error => {
          console.error(error);
          return Promise.reject(error);
      });
    },
      
    async initializeStore({ commit,state }) {
      // console.log(state);
      commit('init');
    },
  },
  getters: {
    // Define your getters if needed
  },
});
