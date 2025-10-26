<script setup>
import TripList from '@/components/TripList.vue';
import { useUser } from '@/composables/useUser.js';
import router from '@/router';

const { user } = useUser();
</script>

<template>
    <body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
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
                        <button class="p-2 hover:bg-gray-100 rounded-lg transition">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </button>
                        <button class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-lg transition">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">{{ user.name  }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Cards de Estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total de Pedidos</p>
                            <p class="text-3xl font-bold text-gray-800">24</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Pendentes</p>
                            <p class="text-3xl font-bold text-yellow-600">8</p>
                        </div>
                        <div class="p-3 bg-yellow-100 rounded-lg">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Aprovados</p>
                            <p class="text-3xl font-bold text-green-600">12</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-lg">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Cancelados</p>
                            <p class="text-3xl font-bold text-red-600">4</p>
                        </div>
                        <div class="p-3 bg-red-100 rounded-lg">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros e Ações -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <h2 class="text-xl font-bold text-gray-800">Pedidos de Viagem</h2>
                    <button 
                    @click="router.push('/create')"
                    class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold px-6 py-2 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition duration-300 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Novo Pedido</span>
                    </button>
                </div>

                <!-- Filtros -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
                    <!-- Filtro Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Todos os status</option>
                            <option value="pendente">Pendente</option>
                            <option value="aprovado">Aprovado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>

                    <!-- Filtro Destino -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Destino</label>
                        <input 
                            type="text" 
                            placeholder="Buscar destino..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Filtro Data Início -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Data Início</label>
                        <input 
                            type="date" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <!-- Filtro Data Fim -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Data Fim</label>
                        <input 
                            type="date" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>
                </div>

                <!-- Botões de Filtro -->
                <div class="flex flex-wrap gap-3 mt-4">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        Aplicar Filtros
                    </button>
                    <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                        Limpar Filtros
                    </button>
                </div>
            </div>

            <!-- Tabela de Pedidos -->
            <TripList></TripList>
        </main>
    </body>
</template>

<style scoped>
</style>