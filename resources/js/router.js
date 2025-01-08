import { createRouter, createWebHistory } from 'vue-router';

import Home from './Pages/Index.vue';
import NotFound from "./Pages/NotFound.vue";

const routes = [
    { path: '/', component: Home },
    { path: '/:pathMatch(.*)*', component: NotFound }, // для обработки 404
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
