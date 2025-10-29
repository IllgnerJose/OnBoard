<script setup>
import DestinationList from '@/components/DestinationList.vue';
import axiosClient from '@/axios';
import router from '@/router';
import { ref } from 'vue';
import { useUser } from '@/composables/useUser.js';
import { useToast } from 'vue-toastification';
import { Plus, CalendarArrowUp, CalendarArrowDown, Info } from 'lucide-vue-next';
import DefaultLayout from '@/components/layouts/DefaultLayout.vue';

const toast = useToast();
const { user } = useUser();

const data = ref({
    departure_date: '',
    return_date: '',
    destination_id : '',
    user_id: user.value.data.id,
})

function createTrip(){
    
    console.log('Dados enviados:', data.value);

    axiosClient.post("api/trips", data.value)
        .then(response => {
            toast.success(response.data.message);
            router.push({name: "Dashboard"});
        })
        .catch(error => {
            toast.error(error.response.data.message);
        })
}
</script>

<template>
    <DefaultLayout>
        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen p-4">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                                <Plus class="w-8 h-8 text-blue-600"/>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">Novo Pedido de Viagem</h2>
                                <p class="text-blue-100">Preencha os dados da sua viagem</p>
                            </div>
                        </div>
                    </div>

                    <form @submit.prevent="createTrip" class="p-8">
                        <div class="space-y-6">
                            <DestinationList v-model="data.destination_id"></DestinationList>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="dataIda">
                                        Data de Ida *
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <CalendarArrowUp class="w-5 h-5 text-gray-400"/>
                                        </div>
                                        <input 
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            id="dataIda" 
                                            type="date" 
                                            v-model="data.departure_date"
                                            required
                                        >
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-gray-700 text-sm font-semibold mb-2" for="dataVolta">
                                        Data de Volta *
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <CalendarArrowDown class="w-5 h-5 text-gray-400"/>
                                        </div>
                                        <input 
                                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            id="dataVolta" 
                                            type="date" 
                                            v-model="data.return_date"
                                            required
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start space-x-3">
                                    <Info class="w-5 h-5 text-blue-600 mt-0.5"/>
                                    <div>
                                        <h3 class="font-semibold text-gray-800 mb-1">Informações Importantes</h3>
                                        <ul class="text-sm text-gray-600 space-y-1">
                                            <li>• A data de volta deve ser posterior à data de ida</li>
                                            <li>• Todos os campos são obrigatórios</li>
                                            <li>• Após o envio, o pedido será analisado</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 mt-8">
                            <button 
                                type="button"
                                class="flex-1 border-2 border-gray-300 text-gray-700 font-semibold py-3 rounded-lg 
                                hover:bg-gray-50 transition duration-300 cursor-pointer"
                                @click="router.push('/dashboard')"
                            >
                                Cancelar
                            </button>
                            <button 
                                type="submit"
                                class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 
                                rounded-lg hover:from-blue-700 hover:to-indigo-700 transition duration-300 shadow-lg 
                                hover:shadow-xl transform hover:-translate-y-0.5 cursor-pointer"
                            >
                                Criar Pedido
                            </button>
                        </div>
                    </form>
                </div>

                <div class="mt-6 text-center text-sm text-gray-600">
                    <p>Precisa de ajuda? Entre em contato com o suporte</p>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<style scoped>
</style>