<script setup>
import { onMounted, ref } from "vue";
import axiosClient from "../axios.js";
import { useToast } from 'vue-toastification';
import { MapPin, ChevronDown } from 'lucide-vue-next';

const toast = useToast();
const destinations = ref([]);
const loading = ref(false);
const errorMessage = ref('');

// Props e Emits para o v-model funcionar
const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: ''
    }
});

const emit = defineEmits(['update:modelValue']);

// Função para atualizar o valor no componente pai
function updateValue(event) {
    emit('update:modelValue', event.target.value);
}

// Busca os destinos da API
async function fetchDestinations() {
    loading.value = true;
    errorMessage.value = '';
    try {
        const response = await axiosClient.get('/api/destinations');
        destinations.value = response.data.data;
    } catch (error) {
        errorMessage.value = 'Não foi possível carregar os destinos.';
        toast.error('Erro ao carregar destinos:', error);
    } finally {
        loading.value = false;
    }
}

onMounted(fetchDestinations);
</script>

<template>
    <div >
        <label class="block text-gray-700 text-sm font-semibold mb-2" for="destino">
            Destino *
        </label>
        
        <!-- Loading State -->
        <div v-if="loading" class="text-gray-500 text-sm py-3">
            Carregando destinos...
        </div>

        <!-- Error State -->
        <div v-else-if="errorMessage" class="text-red-500 text-sm py-3 bg-red-50 px-4 rounded-lg">
            {{ errorMessage }}
        </div>

        <!-- Select de Destinos -->
        <div v-else class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <MapPin class="w-5 h-5 text-gray-400"/>
            </div>
            
            <!-- Ícone de seta do select -->
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <ChevronDown class="w-5 h-5 text-gray-400"/>
            </div>
            
            <select 
                class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg 
                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition 
                appearance-none bg-white cursor-pointer z-0"
                id="destino"
                :value="modelValue"
                @input="updateValue"
                required
            >
                <option value="" disabled>Selecione o destino</option>
                <option 
                    v-for="destination in destinations" 
                    :key="destination.id" 
                    :value="destination.id"
                >
                    {{ destination.city }} - {{ destination.state }}
                </option>
            </select>
        </div>
        
        <p class="mt-1 text-sm text-gray-500">Selecione a cidade e estado de destino</p>
    </div>
</template>