//Converte string DD/MM/YYYY para objeto Date
export function parseDate(str) {
    if (!str) return null;
    const [day, month, year] = str.split('/');
    return new Date(Number(year), Number(month) - 1, Number(day));
}

//Converte data YYYY-MM-DD para DD/MM/YYYY/
export function formatDateToBR(str) {
    if (!str) return '';
    const [year, month, day] = str.split('-');
    return `${day}/${month}/${year}`;
}

//Verifica se uma viagem está dentro do período especificado
export function isTripInDateRange(departureDate, returnDate, filterStart, filterEnd) {
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
}
