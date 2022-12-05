import {createRouter, createWebHistory} from 'vue-router'
import AdministrationRoutes from "@/modules/administration/adminstration-routes.js";
import AuthRoutes from "@/modules/authentication/auth-routes.js";

const routes = [
    ...AdministrationRoutes,
    ...AuthRoutes,
    {
        path: "/:catchAll(.*)",
        name: "NotFound",
        redirect: {name: 'products'},
        meta: {
            requiresAuth: false
        }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
