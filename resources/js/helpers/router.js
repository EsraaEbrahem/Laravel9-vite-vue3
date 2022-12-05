import {createRouter, createWebHistory} from 'vue-router'
import AdministrationRoutes from "@/modules/administration/adminstration-routes.js";
import AuthRoutes from "@/modules/authentication/auth-routes.js";
import PagesRoutes from "@/modules/pages/pages-routes";

const routes = [
    ...AdministrationRoutes,
    ...PagesRoutes,
    ...AuthRoutes,
    {
        path: "/:catchAll(.*)",
        name: "NotFound",
        redirect: {name: 'home'},
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
