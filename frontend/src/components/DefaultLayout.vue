<script setup>
import axiosClient from '@/axios';
import { useUser } from '@/composables/useUser.js';
import { useRouter } from 'vue-router';
import { ref } from 'vue';
import NotificationBell from '@/components/NotificationBell.vue';
import { ChevronDown, LogOut, Plane, User } from 'lucide-vue-next';

const { user } = useUser();
const router = useRouter();
const showUserMenu = ref(false);

function logout(){
    axiosClient.get('/sanctum/csrf-cookie').then(() => {
        axiosClient.post("api/logout")
            .then(response => {
                localStorage.removeItem('token');
                router.push({name: "Login"});
            })
            .catch(error => {
                console.error(error.response.data.message);
            })
    });
}
</script>

<template>
    <header class="bg-white shadow-md sticky top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg">
                        <Plane color="#ffffff"/>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">OnBoard</h1>
                        <p class="text-sm text-gray-500">Dashboard de Viagens Corporativas</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <NotificationBell />
                    
                    <div class="relative">
                        <button 
                            @click="showUserMenu = !showUserMenu"
                            class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-lg transition"
                        >
                            <User class="text-gray-600"/>
                            <span class="text-sm font-medium text-gray-700">{{ user.data.name }}</span>
                            <ChevronDown class="w-4 h-4  text-gray-600"/>
                        </button>

                        <div 
                            v-if="showUserMenu"
                            @click="showUserMenu = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50"
                        >
                            <button
                                @click="logout"
                                class="w-full flex items-center space-x-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition"
                            >
                                <LogOut class="w-4 h-4" />
                                <span>Sair</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <RouterView/>
</template>

<style scoped>

</style>