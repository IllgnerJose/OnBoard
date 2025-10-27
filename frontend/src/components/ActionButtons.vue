<script setup>
import { Check, X } from 'lucide-vue-next';
import axiosClient from '@/axios';
import { ref } from 'vue';
import { useToast } from 'vue-toastification';

const toast = useToast();

const props = defineProps({
  tripId: {
    type: Number,
    required: true
  }
});

const emit = defineEmits(['tripUpdated']);

const data = ref({
    status_id: '',
})

const errorMessage = ref('');

function approveTrip(){
    errorMessage.value = '';
    
    axiosClient.put(`api/approve/${props.tripId}`, data.value)
        .then(response => {
            toast.success(response.data.message);
            emit('tripUpdated');
        })
        .catch(error => {
            toast.error(error.response.data.message);
            errorMessage.value = error.response.data.message;
        })
}    

function cancelTrip(){
    errorMessage.value = '';
    
    axiosClient.put(`api/cancel/${props.tripId}`, data.value)
        .then(response => {
            toast.success(response.data.message);
            emit('tripUpdated');
        })
        .catch(error => {
            toast.error(error.response.data.message);
            errorMessage.value = error.response.data.message;
        })
}   
</script>

<template>
    <td class="px-6 py-4">
        <div class="flex space-x-2">
            <button @click="approveTrip" class="p-1 text-green-600 hover:bg-green-50 rounded transition" title="Aprovar">
                <Check/>
            </button>

            <button @click="cancelTrip" class="p-1 text-red-600 hover:bg-red-50 rounded transition" title="Cancelar">
                <X/>
            </button>
        </div>
    </td>
</template>

<style></style>