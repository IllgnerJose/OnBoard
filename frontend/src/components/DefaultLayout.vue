<script setup>

import { useUser } from '@/composables/useUser.js';
import NotificationBell from '@/components/NotificationBell.vue';

const { user } = useUser();

</script>

<template>
    <!-- Header -->
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
                        <!-- Sino de Notificações -->
                        <NotificationBell />
                        
                        <!-- Usuário -->
                        <button class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-lg transition">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">{{ user.data.name }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>
    <RouterView/>
</template>

<style scoped>

</style>