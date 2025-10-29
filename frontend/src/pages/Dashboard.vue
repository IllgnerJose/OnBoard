<script setup>
import TripList from '@/components/TripList.vue';
import { ref, computed, onMounted } from 'vue';
import axiosClient from '@/axios';
import router from '@/router';
import { useToast } from 'vue-toastification';

const toast = useToast();
const trips = ref([]);
const loading = ref(false);

const searchId = ref('');

const filters = ref({
    status: '',
    destination: '',
    startDate: '',
    endDate: ''
});

// Carregar todas as viagens
async function loadTrips() {
    loading.value = true;
    try {
        const response = await axiosClient.get('/api/trips');
        trips.value = response.data.data;
    } catch (error) {
        toast.error('Erro ao carregar viagens:', error);
        trips.value = [];
    } finally {
        loading.value = false;
    }
}

// Buscar viagem específica por ID no backend
async function searchById() {
    if (!searchId.value.trim()) {
        loadTrips(); // Se não tem ID, carrega todas as viagens
        return;
    }
    
    loading.value = true;
    try {
        // Substitua pela sua rota do backend que busca por ID
        const response = await axiosClient.get(`/api/trips/${searchId.value}`);
        
        // Se retornar um objeto, coloca em array; se retornar array, usa direto
        trips.value = Array.isArray(response.data.data) 
            ? response.data.data 
            : [response.data.data];
    } catch (error) {
        toast.error('Erro ao buscar viagem por ID:', error);
        trips.value = [];
    } finally {
        loading.value = false;
    }
}

// Filtrar viagens (apenas filtros locais, não inclui ID)
const filteredTrips = computed(() => {
    let result = [...trips.value];

    // Filtro por Status
    if (filters.value.status) {
        result = result.filter(trip => 
            trip.status.name.toLowerCase() === filters.value.status.toLowerCase()
        );
    }

    // Filtro por Destino (busca em cidade e estado)
    if (filters.value.destination) {
        const searchTerm = filters.value.destination.toLowerCase();
        result = result.filter(trip => {
            const city = trip.destination.city.toLowerCase();
            const state = trip.destination.state.toLowerCase();
            return city.includes(searchTerm) || state.includes(searchTerm);
        });
    }

    // Filtro por Data
    if (filters.value.startDate || filters.value.endDate) {
        const parseDate = (str) => {
            if (!str) return null;
            const [day, month, year] = str.split('/');
            return new Date(Number(year), Number(month) - 1, Number(day));
        };

        const formatDateToBR = (str) => {
            if (!str) return '';
            const [year, month, day] = str.split('-');
            return `${day}/${month}/${year}`;
        };

        const filterStart = parseDate(formatDateToBR(filters.value.startDate));
        const filterEnd = parseDate(formatDateToBR(filters.value.endDate));

        result = result.filter(trip => {
            const departureDate = parseDate(trip.departure_date);
            const returnDate = parseDate(trip.return_date);

            if (!departureDate || !returnDate) return false;

            // Se apenas data inicial definida
            if (filterStart && !filterEnd) {
                return departureDate >= filterStart || returnDate >= filterStart;
            }

            // Se apenas data final definida
            if (!filterStart && filterEnd) {
                return departureDate <= filterEnd || returnDate <= filterEnd;
            }

            // Se ambas definidas - viagem acontece dentro do período
            if (filterStart && filterEnd) {
                return (
                    (departureDate >= filterStart && departureDate <= filterEnd) ||
                    (returnDate >= filterStart && returnDate <= filterEnd) ||
                    (departureDate <= filterStart && returnDate >= filterEnd)
                );
            }

            return true;
        });
    }

    return result;
});

// Estatísticas computadas baseadas nas viagens filtradas
const stats = computed(() => {
    const total = filteredTrips.value.length;
    const pending = filteredTrips.value.filter(t => t.status.name === 'REQUESTED').length;
    const approved = filteredTrips.value.filter(t => t.status.name === 'APPROVED').length;
    const canceled = filteredTrips.value.filter(t => t.status.name === 'CANCELED').length;

    return { total, pending, approved, canceled };
});

// Limpar todos os filtros e busca
function clearFilters() {
    filters.value = {
        status: '',
        destination: '',
        startDate: '',
        endDate: ''
    };
    searchId.value = '';
    loadTrips(); // Recarrega todas as viagens
}

// Recarregar viagens (callback do TripList)
function handleTripsUpdated() {
    if (searchId.value.trim()) {
        searchById(); // Se estava buscando por ID, refaz a busca
    } else {
        loadTrips(); // Senão, recarrega todas
    }
}

onMounted(() => {
    loadTrips();
});
</script>

<template>
    <body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Cards de Estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total de Pedidos</p>
                            <p class="text-3xl font-bold text-gray-800">{{ stats.total }}</p>
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
                            <p class="text-3xl font-bold text-yellow-600">{{ stats.pending }}</p>
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
                            <p class="text-3xl font-bold text-green-600">{{ stats.approved }}</p>
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
                            <p class="text-3xl font-bold text-red-600">{{ stats.canceled }}</p>
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
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Pedidos de Viagem</h2>
                    <button 
                        @click="router.push('/create')"
                        class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold px-6 py-2 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition duration-300 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Novo Pedido</span>
                    </button>
                </div>

                <!-- Busca por ID (Destacada) -->
                <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                        </svg>
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
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
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
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium flex items-center gap-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
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
        </main>
    </body>
</template>

<style scoped>
</style>