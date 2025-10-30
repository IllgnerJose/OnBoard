<script setup>
import TripList from '@/components/TripList.vue';
import { ref, computed, onMounted } from 'vue';
import axiosClient from '@/axios';
import router from '@/router';
import { useToast } from 'vue-toastification';
import { Clipboard, Clock, CircleCheck, CircleX, Plus, Search, X, Hash } from 'lucide-vue-next';
import DefaultLayout from '@/components/layouts/DefaultLayout.vue';
import { searchTripFilters } from '@/composables/searchTripFilters';

const toast = useToast();
const trips = ref([]);
const loading = ref(false);

async function loadTrips() {
    loading.value = true;
    try {
        const response = await axiosClient.get('/api/trips');
        trips.value = response.data.data;
    } catch (error) {
        toast.error('Erro ao carregar pedido de viagenm:', error);
        trips.value = [];
    } finally {
        loading.value = false;
    }
}

async function searchById() {
    if (!searchId.value.trim()) {
        loadTrips(); 
        return;
    }
    
    loading.value = true;
    try {
        const response = await axiosClient.get(`/api/trips/${searchId.value}`);
        
        trips.value = Array.isArray(response.data.data) 
            ? response.data.data 
            : [response.data.data];
    } catch (error) {
        toast.error('Erro ao buscar pedido de viagem por ID:', error);
        trips.value = [];
    } finally {
        loading.value = false;
    }
}

const { filters, filteredTrips, stats, clearFilters: clearFilterValues } = searchTripFilters(trips);

const searchId = ref('');

async function handleSearchById() {
    await searchById(searchId.value);
}

function clearFilters() {
    clearFilterValues();
    searchId.value = '';
    loadTrips();
}

function handleTripsUpdated() {
    if (searchId.value.trim()) {
        handleSearchById();
    } else {
        loadTrips();
    }
}

onMounted(() => {
    loadTrips();
});
</script>

<template>
    <DefaultLayout>
        <main class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Total de Pedidos</p>
                                <p class="text-3xl font-bold text-gray-800">{{ stats.total }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <Clipboard class="w-8 h-8 text-blue-600" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Pendentes</p>
                                <p class="text-3xl font-bold text-yellow-600">{{ stats.pending }}</p>
                            </div>
                            <div class="p-3 bg-yellow-100 rounded-lg">
                                <Clock class="w-8 h-8 text-yellow-600"/>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Aprovados</p>
                                <p class="text-3xl font-bold text-green-600">{{ stats.approved }}</p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-lg">
                                <CircleCheck class="w-8 h-8 text-green-600"/>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Cancelados</p>
                                <p class="text-3xl font-bold text-red-600">{{ stats.canceled }}</p>
                            </div>
                            <div class="p-3 bg-red-100 rounded-lg">
                                <CircleX class="w-8 h-8 text-red-600"/>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filtros e Ações -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Pedidos de Viagem</h2>
                        <button 
                            @click="router.push('/create')"
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold px-6 py-2 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition duration-300 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2 cursor-pointer"
                        >
                            <Plus class="w-5 h-5"/>
                            <span>Novo Pedido</span>
                        </button>
                    </div>

                    <!-- Busca por ID (Destacada) -->
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <Hash class="w-4 h-4 inline-block mr-1"/>
                            Buscar Pedido por ID
                        </label>
                        <div class="flex gap-2">
                            <input 
                                v-model="searchId"
                                type="text" 
                                placeholder="Digite o ID do pedido..."
                                @keyup.enter="searchById"
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            <button 
                                @click="searchById"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center gap-2 cursor-pointer"
                            >
                                <Search class="w-5 h-5"/>
                                Buscar
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Pressione Enter ou clique em Buscar para pesquisar por ID específico</p>
                    </div>

                    <!-- Divisor -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex-1 border-t border-gray-300"></div>
                        <span class="text-sm text-gray-500 font-medium">OU FILTRE POR</span>
                        <div class="flex-1 border-t border-gray-300"></div>
                    </div>

                    <!-- Filtros Locais -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Filtro Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select 
                                v-model="filters.status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">Todos os status</option>
                                <option value="REQUESTED">Pendente</option>
                                <option value="APPROVED">Aprovado</option>
                                <option value="CANCELED">Cancelado</option>
                            </select>
                        </div>

                        <!-- Filtro Destino -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Destino</label>
                            <input 
                                v-model="filters.destination"
                                type="text" 
                                placeholder="Buscar cidade ou estado..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <!-- Filtro Data Início -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Data Início</label>
                            <input 
                                v-model="filters.startDate"
                                type="date" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <!-- Filtro Data Fim -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Data Fim</label>
                            <input 
                                v-model="filters.endDate"
                                type="date" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex flex-wrap gap-3 mt-6">
                        <button 
                            @click="clearFilters"
                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium flex items-center gap-2 cursor-pointer"
                        >
                            <X class="w-4 h-4"/>
                            Limpar Tudo
                        </button>
                        <div class="flex-1"></div>
                        <span class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium">
                            {{ filteredTrips.length }} resultado(s) encontrado(s)
                        </span>
                    </div>
                </div>

                <!-- Tabela de Pedidos -->
                <TripList 
                    :trips="filteredTrips" 
                    :loading="loading"
                    @trips-updated="handleTripsUpdated"
                />
            </div>
        </main>
    </DefaultLayout>
</template>

<style scoped>
</style>