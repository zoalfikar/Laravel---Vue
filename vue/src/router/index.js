import { createRouter, createWebHistory } from "vue-router";
import DefaultLayout from '../components/DefaultLayout.vue';
import AuthLayout from '../components/AuthLayout.vue';
import store from "../store";
import Dashboard from '../views/Dashboard.vue';
import Login from '../views/login.vue';
import Register from '../views/register.vue';
import SurveyPublic from '../views/SurveyPublicView.vue';
import Surveys from '../views/Survey.vue';
import SurveysView from '../views/surveysView.vue'


const routes = [{
        path: '/view/survey/:slug',
        name: 'SurveyPublic',
        component: SurveyPublic
    },
    {
        path: '/',
        redirect: '/dashboard',
        component: DefaultLayout,
        meta: { requiresAuth: true },
        children: [{
            path: '/dashboard',
            name: 'Dashboard',
            component: Dashboard,
        }, {
            path: '/surveys',
            name: 'Surveys',
            component: Surveys,
        }, {
            path: '/surveys/:id',
            name: 'SurveyView',
            component: SurveysView,
        }, {
            path: '/surveys/create',
            name: 'SurveyCreate',
            component: SurveysView,
        }]
    },
    {
        path: '/auth',
        redirect: '/login',
        name: 'Auth',
        meta: { isGuest: true },
        component: AuthLayout,
        children: [{
                path: '/login',
                name: 'Login',
                component: Login
            },
            {
                path: '/register',
                name: 'Register',
                component: Register
            }
        ]

    },

]
const router = createRouter({
    history: createWebHistory(),
    routes
})
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: 'Login' })

    } else if (store.state.user.token && (to.meta.isGuest)) {
        next({ name: 'Dashboard' })
    } else { next() }
})
export default router;