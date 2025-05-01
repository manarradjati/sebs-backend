import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    // { path: '/', redirect: '/login' },
    {
      path: '/',
      component: () => import('../views/Bookify/layout/blank.vue'),
      children: [
        // {
        //   path: '',
        //   component: () => import('../views/Bookify/LandingPage.vue'),
        // },
        {
          path: 'login',
          component: () => import('../views/Auth/login.vue'),
        },
        {
          path: 'register',
          component: () => import('../views/Auth/register.vue'),
        },

        {
          path: '/profile/:username',
          component: () => import('../views/Others/Profile.vue'),
        },
        
        {
          path: '/:pathMatch(.*)*',
          component: () => import('../views/Others/404Error.vue'),
        },
      ],
    },
    {
      path: '/',
      component: () => import('../views/Bookify/layout/default.vue'),
      children: [
        {
          path: 'dashboard',
          component: () => import('../views/Bookify/dashboard.vue'),
        },
        {
          path: 'account-settings',
          component: () => import('../views/Bookify/account/account-settings.vue'),
        },


        {
          path: 'books',
          component: () => import('../views/Bookify/books/list.vue'),
        },
        {
          path: 'genres',
          component: () => import('../views/Bookify/genres/list.vue'),
        },
        {
          path: 'authors',
          component: () => import('../views/Bookify/authors/list.vue'),
        },
        {
          path: 'orders',
          component: () => import('../views/Bookify/orders/list.vue'),
        },







        {
          path: 'dashboard-example',
          component: () => import('../views/Bookify/dashboard.vue'),
        },
        {
          path: 'typography',
          component: () => import('../views/v-pages/typography.vue'),
        },
        {
          path: 'icons',
          component: () => import('../views/v-pages/icons.vue'),
        },
        {
          path: 'cards',
          component: () => import('../views/v-pages/cards.vue'),
        },
        {
          path: 'tables',
          component: () => import('../views/v-pages/tables.vue'),
        },
        {
          path: 'form-layouts',
          component: () => import('../views/v-pages/form-layouts.vue'),
        },
      ],
    },
  ],
})

export default router
