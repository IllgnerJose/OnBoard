<script setup>
import DestinationList from '@/components/DestinationList.vue';
import axiosClient from '@/axios';
import router from '@/router';
import { ref } from 'vue';
import { useUser } from '@/composables/useUser.js';


const { user } = useUser();

const data = ref({
    departure_date: '',
    return_date: '',
    destination_id : '',
    user_id: user.value.id,
})

const errorMessage = ref('');

function submit(){
    errorMessage.value = '';
    
    axiosClient.post("api/trips", data.value)
        .then(response => {
            router.push({name: "Dashboard"});
        })
        .catch(error => {
            console.log(error.response)
            errorMessage.value = error.response.data.message;
        })
}
</script>

<template>
    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen p-4">
        <!-- Header -->
        <div class="max-w-4xl mx-auto mb-6">
            <div class="bg-white rounded-lg shadow-md p-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Sistema de Agendamento</h1>
                        <p class="text-sm text-gray-500">Gestão de Viagens</p>
                    </div>
                </div>
                <button class="text-gray-600 hover:text-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Formulário Principal -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <!-- Header do Formulário -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Novo Pedido de Viagem</h2>
                            <p class="text-blue-100">Preencha os dados da sua viagem</p>
                        </div>
                    </div>
                </div>

                <!-- Corpo do Formulário -->
                <form @submit.prevent="submit" class="p-8">
                    <div class="space-y-6">
                        <!-- Campo Destino -->
                        <DestinationList v-model="data.destination_id"></DestinationList>

                        <!-- Datas em Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Data de Ida -->
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2" for="dataIda">
                                    Data de Ida *
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
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

                            <!-- Data de Volta -->
                            <div>
                                <label class="block text-gray-700 text-sm font-semibold mb-2" for="dataVolta">
                                    Data de Volta *
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
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

                        <!-- Card de Resumo -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
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

                    <!-- Botões de Ação -->
                    <div class="flex flex-col sm:flex-row gap-4 mt-8">
                        <button 
                            type="button"
                            class="flex-1 border-2 border-gray-300 text-gray-700 font-semibold py-3 rounded-lg hover:bg-gray-50 transition duration-300"
                            @click="router.push('/dashboard')"
                        >
                            Cancelar
                        </button>
                        <button 
                            type="submit"
                            class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        >
                            Criar Pedido
                        </button>
                    </div>
                </form>
            </div>

            <!-- Rodapé com informações -->
            <div class="mt-6 text-center text-sm text-gray-600">
                <p>Precisa de ajuda? Entre em contato com o suporte</p>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>