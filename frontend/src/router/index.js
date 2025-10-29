import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from '@/pages/Dashboard.vue';
import Login from '@/pages/Login.vue';
import Register from '@/pages/Register.vue';
import NotFound from '@/pages/NotFound.vue';
import Create from '@/pages/Create.vue';
import useUserStore from "@/store/user.js";
import DefaultLayout from '@/components/DefaultLayout.vue';
import GuestLayout from '@/components/GuestLayout.vue';

const routes = [
  {
    path: "/app",
    component: DefaultLayout,
    children: [
      { path: '/create', name: 'Create', component: Create },
      { path: '/dashboard', name: 'Dashboard', component: Dashboard },
    ],
    beforeEnter: async (to, from, next) => {
      try {
        const userStore = useUserStore();
        await userStore.fetchUser();
        next();
      } catch (error) {
        next(false);
      }
    },
  },
  {
    path: "/",
    component: GuestLayout,
    children: [
      { path: 'login', name: 'Login', component: Login },
      { path: 'register', name: 'Register', component: Register },
    ],
  },
  { 
    path: '/:pathMatch(.*)*', 
    name: 'NotFound', 
    component: NotFound 
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

export default router
