import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from '@/pages/Dashboard.vue';
import Login from '@/pages/Login.vue';
import Register from '@/pages/Register.vue';
import NotFound from '@/pages/NotFound.vue';
import Create from '@/pages/Create.vue';
import useUserStore from "@/store/user.js";

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: { title: 'Cadastro', requiresAuth: false },
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    meta: { title: 'Registro', requiresAuth: false },
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: NotFound,
    meta: { title: 'Not Found', requiresAuth: false  },
  },
  {
    path: '/create',
    name: 'Create',
    component: Create,
    meta: { title: 'Criar Pedido', requiresAuth: true },
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
    meta: { title: 'Dashboard', requiresAuth: true },
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  document.title = to.meta.title + ' - OnBoard' || 'OnBoard';
  next();
});

router.beforeEach(async (to, from, next) => {
  if (to.meta.requiresAuth) {
    try {
      const userStore = useUserStore();
      await userStore.fetchUser();
      next();
    } catch (error) {
      next('/login');
    }
  } else {
    next();
  }
});

export default router
