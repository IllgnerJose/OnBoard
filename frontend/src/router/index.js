import Dashboard from '@/pages/Dashboard.vue';
import Login from '@/pages/Login.vue';
import NotFound from '@/pages/Create.vue';
import Create from '@/pages/Create.vue';
import { createRouter, createWebHistory } from 'vue-router'
import useUserStore from "@/store/user.js";
import DefaultLayout from '@/components/DefaultLayout.vue';

const routes = [
  {
    path: "/",
    component: DefaultLayout,
    children: [
      {path: '/create', name: 'Create', component: Create},
      {path: '/dashboard', name: 'Dashboard', component: Dashboard},
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
    path: "/login", 
    name: "Login", 
    component: Login,
  },
  {
    path: "/:pathMatch(.*)*", 
    name: "NotFound", 
    component: NotFound,
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

export default router
