// import vue router 
import { createRouter, createWebHistory } from 'vue-router' 
 
// define routes 
const routes = [ 
    { 
        path: '/', 
        name: 'home', 
        component: () => import(/* webpackChunkName: "home" */ '../views/home.vue') 
    }, 
    { 
        path: '/pengaduan', 
        name: 'pengaduan', 
        component: () => import(/* webpackChunkName: "pengaduan" */ '../views/pengaduan/index.vue') 
    }, 
    {
        path: '/buat-aduan',
        name: 'buat-aduan',
        component: () => import(/* webpackChunkName: "buat-aduan" */ '../views/FormPengaduan/formpengaduan.vue') 
    },
    {
        path: '/aduan-saya',
        name: 'aduan-saya',
        component: () => import(/* webpackChunkName: "aduan-saya" */ '../views/myaduan/index.vue') 
    },
    {
        path: '/detail-aduan',
        name: 'detail-aduan',
        component: () => import(/* webpackChunkName: "detail-aduan" */ '../views/myaduan/detail.vue') 
    },
    {
        path: '/statistik',
        name: 'statistik',
        component: () => import(/* webpackChunkName: "statistik" */ '../views/statistik/index.vue')
    },
    {
        path: '/#service',
        name: 'service',
        component: () => import(/* webpackChunkName: "home" */ '../views/home.vue')
    },
    {
        path: '/#contact',
        name: 'contact',
        component: () => import(/* webpackChunkName: "home" */ '../App.vue')
    },
    {
        path: '/login',
        name: 'login',
        component: () => import(/* webpackChunkName: "login" */ '../views/login.vue')
    },
    {
        path: '/my-complaint',
        name: 'my-complaint',
        component: () => import(/* webpackChunkName: "my-complaint" */ '../views/complaint-list.vue')
    },
    {
        path: '/admin-dashboard',
        name: 'admin-dashboard',
        component: () => import(/* webpackChunkName: "admin-dashboard" */ '../views/admin-dashboard.vue')
    },
    { 
        path: '/fasilitas', 
        name: 'fasilitas', 
        component: () => import(/* webpackChunkName: "fasilitas" */ '../views/kategori/fasilitas.vue') 
    }, 
    { 
        path: '/akademik', 
        name: 'akademik', 
        component: () => import(/* webpackChunkName: "akademik" */ '../views/kategori/akademik.vue') 
    }, 
    { 
        path: '/kebersihan', 
        name: 'kebersihan', 
        component: () => import(/* webpackChunkName: "kebersihan" */ '../views/kategori/kebersihan.vue') 
    }, 
    { 
        path: '/layanan', 
        name: 'layanan', 
        component: () => import(/* webpackChunkName: "layanan" */ '../views/kategori/layanan.vue') 
    },
    {
        path: '/faq',
        name: 'faq',
        component: () => import(/* webpackChunkName: "faq" */ '../views/FAQ.vue')
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: () => import(/*webpackChunkName: "admin" */ '../views/dashboard.vue')
    }
]

const router = createRouter({ 
    history: createWebHistory(), 
    routes
}) 

export default router