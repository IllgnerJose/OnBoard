import { ref, computed } from 'vue';
import { parseDate, formatDateToBR } from '@/utils/dateHelpers';

export function searchTripFilters(trips) {
    const filters = ref({
        status: '',
        destination: '',
        startDate: '',
        endDate: ''
    });

    const filteredTrips = computed(() => {
        let result = [...trips.value];

        // Filtro por Status
        if (filters.value.status) {
            result = result.filter(trip => 
                trip.status.name.toLowerCase() === filters.value.status.toLowerCase()
            );
        }

        // Filtro por Destino
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

                // Se ambas definidas
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

    const stats = computed(() => {
        const total = filteredTrips.value.length;
        const pending = filteredTrips.value.filter(t => t.status.name === 'REQUESTED').length;
        const approved = filteredTrips.value.filter(t => t.status.name === 'APPROVED').length;
        const canceled = filteredTrips.value.filter(t => t.status.name === 'CANCELED').length;

        return { total, pending, approved, canceled };
    });

    function clearFilters() {
        filters.value = {
            status: '',
            destination: '',
            startDate: '',
            endDate: ''
        };
    }

    return {
        filters,
        filteredTrips,
        stats,
        clearFilters
    };
}