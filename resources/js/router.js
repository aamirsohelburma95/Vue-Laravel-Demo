import Vue from "vue";
import Router from "vue-router";
import store from './store'

import Home from "./pages/Home.vue";
import Login from "./pages/Login.vue";
import Register from "./pages/Register.vue";
import Dashboard from './pages/Dashboard.vue';
import Booking from './pages/Booking.vue';
import History from './pages/History.vue';

Vue.use(Router);

const router = new Router({
    mode: 'history',
    routes: [{
            path: '',
            name: 'home',
            component: Home,
            props: true,
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                guest: true
            }
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
            meta: {
                guest: true
            }
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Dashboard,
            meta: {
                requireAuth: true
            }
        },
        {
            path: '/history',
            name: 'history',
            component: History,
            meta: {
                requireAuth: true
            }
        },
        {
            path: '/booking/:id',
            name: 'booking',
            component: Booking,
            meta: {
                requireAuth: true
            }
        },
    ]
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requireAuth)) {
        if (store.getters.isLoggedIn) {
            next();
            return;
        }
        next("/login");
    } else {
        next();
    }
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.guest)) {
        if (store.getters.isLoggedIn) {
            next("/dashboard");
            return;
        }
        next();
    } else {
        next();
    }
});
export default router;