<script setup>
import axiosClient from '@/axios';
import { useUser } from '@/composables/useUser.js';
import { useRouter } from 'vue-router';
import { ref } from 'vue';
import NotificationBell from '@/components/NotificationBell.vue';
import { useToast } from 'vue-toastification';

const toast = useToast();
const { user } = useUser();
const router = useRouter();
const showUserMenu = ref(false);

function submit(){
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
    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Sistema de Agendamento</h1>
                        <p class="text-sm text-gray-500">Dashboard de Viagens</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <NotificationBell />
                    
                    <!-- Usuário com menu dropdown -->
                    <div class="relative">
                        <button 
                            @click="showUserMenu = !showUserMenu"
                            class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-lg transition"
                        >
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">{{ user.data.name }}</span>
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Menu Dropdown -->
                        <div 
                            v-if="showUserMenu"
                            @click="showUserMenu = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50"
                        >
                            <button
                                @click="submit"
                                class="w-full flex items-center space-x-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
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