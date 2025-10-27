<!-- components/TripList.vue -->
<script setup>
import { computed } from "vue";
import ActionButtons from "./ActionButtons.vue";
import StatusBadge from "./ui/StatusBadge.vue";
import { useUser } from '@/composables/useUser.js';

const { user } = useUser();

const props = defineProps({
    trips: {
        type: Array,
        default: () => []
    },
    loading: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['tripsUpdated']);

const isAdmin = computed(() => user.value?.data?.role === 'admin');

const reloadTrips = () => {
    emit('tripsUpdated');
};
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
                    <!-- Loading -->
                    <tr v-if="loading">
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex justify-center items-center">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                                <span class="ml-3">Carregando...</span>
                            </div>
                        </td>
                    </tr>

                    <!-- Sem resultados -->
                    <tr v-else-if="trips.length === 0">
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            Nenhuma viagem encontrada com os filtros aplicados.
                        </td>
                    </tr>

                    <!-- Lista de viagens -->
                    <tr 
                        v-else
                        v-for="trip in trips" 
                        :key="trip.id"
                        class="hover:bg-gray-50 transition"
                    >
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">#{{ trip.id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ trip.destination.city }} - {{ trip.destination.state }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ trip.departure_date }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ trip.return_date }}</td>
                        <td class="px-6 py-4">
                            <StatusBadge :status="trip.status.name" />
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