<!-- StatusBadge.vue -->
<script setup>
const props = defineProps({
    status: {
        type: String,
        required: true
    }
});

const statusConfig = {
    'REQUESTED': { 
        label: 'PENDENTE', 
        color: 'bg-yellow-100 text-yellow-800' 
    },
    'APPROVED': { 
        label: 'APROVADO', 
        color: 'bg-green-100 text-green-800' 
    },
    'CANCELED': { 
        label: 'CANCELADO', 
        color: 'bg-red-100 text-red-800' 
    },
};

const getStatusInfo = (statusName) => {
    return statusConfig[statusName] || { 
        label: statusName, 
        color: 'bg-gray-100 text-gray-800' 
    };
};
</script>

<template>
    <span 
        class="px-3 py-1 text-xs font-semibold rounded-full"
        :class="getStatusInfo(status).color"
    >
        {{ getStatusInfo(status).label }}
    </span>
</template>