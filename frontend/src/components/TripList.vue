<script setup>
import { onMounted, ref } from "vue";
import axiosClient from "../axios.js";
import ActionButtons from "./ActionButtons.vue";
import { useUser } from '@/composables/useUser.js';
import StatusBadge from "./ui/StatusBadge.vue";

const { user } = useUser();

const isAdmin = ref(user.value.data.is_admin);
const trips = ref([]);
const loading = ref(false);
const errorMessage = ref('');

async function loadTrips() {
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

const reloadTrips = async () => {
    loadTrips();
};

onMounted(loadTrips);
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
                        <th v-if="isAdmin" class="px-6 py-4 text-left text-sm font-semibold">Ações</th>
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
                            <StatusBadge :status="trip.status.name"/>
                        </td>
                        <ActionButtons 
                            v-if="isAdmin"
                            :trip-id="trip.id"
                            @trip-updated="reloadTrips"
                        />
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>