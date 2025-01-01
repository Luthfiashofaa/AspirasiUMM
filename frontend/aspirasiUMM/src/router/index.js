//import vue router 
import { createRouter, createWebHistory } from 'vue-router' 
 
//define a routes 
const routes = [ 
    { 
        path: '/', 
        name: 'home', 
        component: () => import( /* webpackChunkName: "home" */ '../views/home.vue') 
    }, 
    { 
        path: '/pengaduan', 
        name: 'pengaduan', 
        component: () => import( /* webpackChunkName: "home" */ '../views/pengaduan/index.vue') 
    }, 
    { 
        path: '/kategori', 
        name: 'kategori', 
        component: () => import( /* webpackChunkName: "pengaduan" */ '../views/kategori/index.vue') 
    }, 
    {
        path: '/statistik',
        name: 'statistik',
        component: () => import( /* webpackChunkName: "home" */ '../views/statistik/index.vue')
    },
    {
        path: '/#service',
        name: 'service',
        component: () => import( /* webpackChunkName: "home" */ 
            '../views/home.vue')
    },
    {
        path: '/#contact',
        name: 'contact',
        component: () => import( /* webpackChunkName: "home" */ 
            '../App.vue')
    },
    {
        path: '/login',
        name: 'login',
        component: () => import( /* webpackChunkName: "home" */ 
            '../views/login.vue')
    },
    {
        path: '/my-complaint',
        name: 'my-complaint',
        component: () => import( /* webpackChunkName: "home" */ 
            '../views/complaint-list.vue')
    },
    {
        path: '/admin-dashboard',
        name: 'admin-dashboard',
        component: () => import( /* webpackChunkName: "home" */ 
            '../views/admin-dashboard.vue')
    },
]

const router = createRouter({ 
    history: createWebHistory(), 
    routes // <-- routes, 
    }) 
    export default router 