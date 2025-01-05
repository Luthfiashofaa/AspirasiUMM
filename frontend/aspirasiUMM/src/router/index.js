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
        path: '/buat-aduan',
        name: 'buat-aduan',
        component: () => import( /* webpackChunkName: "home" */ '../views/FormPengaduan/formpengaduan.vue') 
    
    },
    {
        path: '/aduan-saya',
        name: 'aduan-saya',
        component: () => import( /* webpackChunkName: "home" */ '../views/myaduan/index.vue') 

    },
    {
        path: '/detail-aduan',
        name: 'detail-aduan',
        component: () => import( /* webpackChunkName: "home" */ '../views/myaduan/detail.vue') 

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




    { 
        path: '/fasilitas', 
        name: 'fasilitas', 
        component: () => import( /* webpackChunkName: "pengaduan" */ '../views/kategori/fasilitas.vue') 
    }, 
    { 
        path: '/akademik', 
        name: 'akademik', 
        component: () => import( /* webpackChunkName: "pengaduan" */ '../views/kategori/akademik.vue') 
    }, 
    { 
        path: '/kebersihan', 
        name: 'kebersihan', 
        component: () => import( /* webpackChunkName: "pengaduan" */ '../views/kategori/kebersihan.vue') 
    }, 
    { 
        path: '/layanan', 
        name: 'layanan', 
        component: () => import( /* webpackChunkName: "pengaduan" */ '../views/kategori/layanan.vue') 
    }, 
]

const router = createRouter({ 
    history: createWebHistory(), 
    routes // <-- routes, 
    }) 
    export default router 