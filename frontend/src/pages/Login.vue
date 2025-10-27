<script setup>
import axiosClient from '@/axios';
import router from '@/router';
import { ref } from 'vue';
import { useToast } from 'vue-toastification';

const toast = useToast();

const data = ref({
    email: '',
    password: '',
})


function submit(){
    axiosClient.get('/sanctum/csrf-cookie').then(() => {
        axiosClient.post("api/login", data.value)
            .then(response => {
                localStorage.setItem("token", response.data.data.token)
                toast.success(response.data.message);
                router.push({name: "Dashboard"});
            })
            .catch(error => {
                toast.error(error.response.data.message);
            })
    });
}
</script>

<template>
    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Card de Login -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <!-- Header com gradiente -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-8 text-center">
                    <div class="inline-block p-3 bg-white rounded-full mb-4">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Bem-vindo!</h1>
                    <p class="text-blue-100">OnBoard</p>
                </div>

                <!-- Formulário -->
                <div class="p-8">
                    <form @submit.prevent="submit">
                        <!-- Campo Email -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">
                                E-mail
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                                <input 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    id="email" 
                                    type="email" 
                                    placeholder="seu@email.com"
                                    v-model="data.email"
                                >
                            </div>
                        </div>

                        <!-- Campo Senha -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-semibold mb-2" for="password">
                                Senha
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <input 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    id="password" 
                                    type="password" 
                                    placeholder="••••••••"
                                    v-model="data.password"
                                >
                            </div>
                        </div>

                        <!-- Lembrar-me e Esqueci senha -->
                        <div class="flex items-center justify-between mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Lembrar-me</span>
                            </label>
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                Esqueceu a senha?
                            </a>
                        </div>

                        <!-- Botão Entrar -->
                        <button 
                            type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        >
                            Entrar
                        </button>
                    </form>

                    <!-- Divisor -->
                    <div class="flex items-center my-6">
                        <div class="flex-1 border-t border-gray-300"></div>
                        <span class="px-4 text-sm text-gray-500">ou</span>
                        <div class="flex-1 border-t border-gray-300"></div>
                    </div>

                    <!-- Registro -->
                    <div class="text-center">
                        <p class="text-gray-600 text-sm">
                            Não tem uma conta? 
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold">
                                Cadastre-se
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>