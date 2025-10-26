import useUserStore from '@/store/user.js';
import { computed } from 'vue';

export function useUser() {
  const userStore = useUserStore();
  const user = computed(() => userStore.user);
  
  return { user, userStore };
}