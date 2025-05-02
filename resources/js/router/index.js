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
          path: 'events',
          component: () => import('../views/Bookify/events/list.vue'),
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

    // صفحات مستقلة
    {
      path: '/profile/:username',
      component: () => import('../views/Others/Profile.vue'),
    },
    {
      path: '/:pathMatch(.*)*',
      component: () => import('../views/Others/404Error.vue'),
    },
  ],
});

export default router;
