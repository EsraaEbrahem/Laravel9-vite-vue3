import Home from '@/modules/pages/home.vue';
import MyOrders from '@/modules/pages/orders/orders.vue';

const PagesRoutes = [
    {
        path: '/home',
        name: 'home',
        component: Home,
        meta: {
            requireAuth: false,
            title: 'Home',
        }
    },
    {
        path: '/my-orders',
        name: 'my-orders',
        component: MyOrders,
        meta: {
            requireAuth: true,
            title: 'Orders',
        }
    }
];

export default PagesRoutes;
