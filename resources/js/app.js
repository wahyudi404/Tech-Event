/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import VueRouter from 'vue-router';
Vue.use(VueRouter);
import VueSweetAlert from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'
Vue.use(VueSweetAlert)

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
import Welcome from './components/Welcome.vue';
import Home from './components/HomeAdmin.vue';
import Detail from './components/Detail.vue';

const routes = [
    {
        name: 'welcome',
        path: '/',
        component: Welcome,
    },
    {
        name: 'home',
        path: '/admin',
        component: Home,
    },
    {
        name: 'detail',
        path: '/detail/:id?',
        component: Detail,
        props: true,
    }
]

const router = new VueRouter({
    mode:'history',
    routes
});

const app = new Vue({
    el: '#app',
    router
});
