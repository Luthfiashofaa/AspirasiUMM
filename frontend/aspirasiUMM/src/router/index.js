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
        component: () => import(/* webpackChunkName: "pengaduan" */ '../views/pengaduan/index.vue') ,
        meta: {
            requiresAuth: true // Add this meta field
          }
    }, 
    {
        path: '/buat-aduan',
        name: 'buat-aduan',
        component: () => import(/* webpackChunkName: "buat-aduan" */ '../views/FormPengaduan/formpengaduan.vue'),
        meta: {
            requiresAuth: true // Add this meta field
          }
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
        path: '/comment/:id',
        name: 'comment',
        component: () => import(/* webpackChunkName: "faq" */ '../views/comments/complaintscomments.vue')
    },

]

const router = createRouter({ 
    history: createWebHistory(), 
    routes
}) 


router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token')
    
    if (to.meta.requiresAuth && !token) {
      // Redirect to login if trying to access protected route without token
      next({ 
        name: 'login',
        query: { redirect: to.fullPath } // Store intended destination
      })
    } else {
      next()
    }
  })

export default router