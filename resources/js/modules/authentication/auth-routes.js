import Profile from '@/modules/authentication/auth/profile.vue';
import Login from '@/modules/authentication/auth/login.vue';
import Register from '@/modules/authentication/auth/register.vue';

const AuthRoutes = [
    {
        path: '/profile',
        name: 'profile',
        component: Profile,
        meta: {
            requireAuth: true,
            title: 'Register',
        }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            requireAuth: false,
            title: 'Register',
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            requireAuth: false,
            title: 'Login',
        }
    },
];

export default AuthRoutes;
