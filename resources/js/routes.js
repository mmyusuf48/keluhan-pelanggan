export const routes = [
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: () => import(/* webpackChunkName: "404" */ './Pages/404.vue')
    },
    {
        path: '/home',
        name: 'home',
        component: () => import(/* webpackChunkName: "home" */ './Pages/Home.vue')
    },
    {
        path: '/keluhan-pelanggan',
        name: 'keluhan_pelanggan',
        component: () => import(/* webpackChunkName: "keluhan_pelanggan" */ './Pages/KeluhanPelanggan.vue')
    },
    {
        path: '/create-keluhan',
        name: 'create-keluhan',
        component: () => import(/* webpackChunkName: "keluhan_pelanggan" */ './Components/CreateKeluhan.vue')
    },
    {
        path: '/keluhan/:id',
        name: 'detail-keluhan',
        component: () => import(/* webpackChunkName: "keluhan_pelanggan" */ './Components/EditKeluhan.vue'),
        props: true
    }
];
