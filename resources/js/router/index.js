import { createRouter, createWebHistory } from 'vue-router';
import store from '@/store';  // تأكد من استيراد store

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', redirect: '/login' },
    {
      path: '/',
      component: () => import('../views/Bookify/layout/blank.vue'),
      children: [
        {
          path: 'login',
          component: () => import('../views/Auth/login.vue'),
        },
        {
          path: 'register',
          component: () => import('../views/Auth/register.vue'),
        },
      ],
    },

    // صفحات التطبيق الرئيسية بتخطيط Default
    {
      path: '/',
      component: () => import('../views/Bookify/layout/default.vue'),
      children: [
        {
          path: '',
          redirect: '/dashboard',  // التوجيه إلى dashboard بشكل افتراضي
        },
        {
          path: 'dashboard',
          component: () => import('../views/Bookify/dashboard.vue'),
          beforeEnter: (to, from, next) => {
            // تحقق من حالة التوثيق قبل السماح بالوصول إلى "dashboard"
            if (!store.state.data) {
              // إذا لم يكن هناك بيانات للمستخدم (أي لم يتم تسجيل الدخول)
              next('/auth/login');  // التوجيه إلى صفحة تسجيل الدخول
            } else {
              next();  // السماح بالوصول إلى dashboard
            }
          }
        },
        {
          path: 'account-settings',
          component: () => import('../views/Bookify/account/account-settings.vue'),
        },

        {
          path: 'events',
          component: () => import('../views/Bookify/events/list.vue'),
        },
        {
          path: 'categories',
          component: () => import('../views/Bookify/categories/list.vue'),
        },
        {
          path: 'organizers',
          component: () => import('../views/Bookify/organizers/list.vue'),
        },
        {
          path: 'users',
          component: () => import('../views/Bookify/users/list.vue'),
        },
        {
          path: 'tickets',
          component: () => import('../views/Bookify/tickets/list.vue'),
        },
        {
          path: 'reviews',
          component: () => import('../views/Bookify/reviews/list.vue'),
        },
        {
          path: 'bookings',
          component: () => import('../views/Bookify/bookings/list.vue'),
        },

        // { path: '/home', name: 'Home', component: Home },
        // { path: '/events/:id', name: 'EventDetails', component: EventDetails, props: true },
        // { path: '/login', name: 'Login', component: Login },
        // { path: '/register', name: 'Register', component: Register },
        // { path: '/admin', name: 'AdminPanel', component: AdminPanel }

        
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
});

export default router;
