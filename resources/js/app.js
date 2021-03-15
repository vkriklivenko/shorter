require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import routes from './routes'
Vue.use(VueRouter)


const router = new VueRouter
({
    mode: 'history',
    routes
})


//Main pages
// import App from './views/app.vue'


const app = new Vue({
    el: '#app',
    router
});