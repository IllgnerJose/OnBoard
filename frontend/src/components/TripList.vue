<script setup>
import { onMounted, ref } from "vue";
import axiosClient from "../axios.js";

const trips = ref([]);
const loading = ref(false);
const errorMessage = ref('');

async function fetchTrips() {
    loading.value = true;
    errorMessage.value = '';
    try {
        const response = await axiosClient.get('/api/trips');
        trips.value = response.data.data;
    } catch (error) {
        errorMessage.value = 'Não foi possível carregar os pedidos de viagem.';
        console.error('Erro ao carregar destinos:', error);
    } finally {
        loading.value = false;
    }
}

onMounted(fetchTrips);
</script>

<template>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">ID</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Destino</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Data de Ida</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Data de Volta</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <!-- Pedido 1 -->
                    <tr 
                        class="hover:bg-gray-50 transition"
                         v-for="trip in trips" 
                        :key="trip.id" 
                        :value="trip.id"
                    >
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">#{{ trip.id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ trip.destination.city }} - {{ trip.destination.state }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ trip.departure_date }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ trip.return_date }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                {{ trip.status.name }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <button class="p-1 text-blue-600 hover:bg-blue-50 rounded transition" title="Visualizar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                                <button class="p-1 text-indigo-600 hover:bg-indigo-50 rounded transition" title="Editar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button class="p-1 text-red-600 hover:bg-red-50 rounded transition" title="Excluir">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>