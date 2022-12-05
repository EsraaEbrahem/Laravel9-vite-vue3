import ProductsIndex from '@/modules/administration/products/index.vue'
import CategoriesIndex from '@/modules/administration/categories/index.vue'
import UsersIndex from '@/modules/administration/users/index.vue'
import OrdersIndex from '@/modules/administration/orders/index.vue'

const AdministrationRoutes = [
    {
        path: '/categories',
        name: 'categories',
        component: CategoriesIndex,
    },
    {
        path: '/products',
        name: 'products',
        component: ProductsIndex,
    },
    {
        path: '/users',
        name: 'users',
        component: UsersIndex,
    },
    {
        path: '/orders',
        name: 'orders',
        component: OrdersIndex,
    }
];

export default AdministrationRoutes;
