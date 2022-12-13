/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import router from './router';
import App from './layouts/App.vue';
import store from './store/index';
// window.Vue = require('vue').default;

// Use Vue 
Vue.use(VueAxios, axios);
Vue.use(VueRouter);

axios.defaults.withCredentials = true;
axios.defaults.baseURL = "http://127.0.0.1:8000/api/";

const token = localStorage.getItem('token');

if (token) {
    axios.defaults.headers.common['Authorization'] = token;
}

// Vue.component('dashboard', require('./components/DashboardComponent.vue').default);

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store
});

// manage error and expire token

axios.interceptors.response.use(undefined, function(error) {
    if (error) {
        const originalRequest = error.config;
        if (error.response.status === 401 && !originalRequest._retry) {
            originalRequest._retry = true;
            store.dispatch('logout')
            return router.push('/login')
        } else {
            store.commit('handle_error', JSON.parse(error.response.data.error));
        }
    }
})