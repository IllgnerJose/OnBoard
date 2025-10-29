<script setup>
import axiosClient from '@/axios';
import router from '@/router';
import { ref } from 'vue';
import { useToast } from 'vue-toastification';
import { AtSign, LockKeyhole, CircleUserRound } from 'lucide-vue-next';
import GuestLayout from '@/components/layouts/GuestLayout.vue';

const toast = useToast();

const data = ref({
    name: '',
    email: '',
    password: '',
    c_password: '',
})

function register(){
    axiosClient.get('/sanctum/csrf-cookie').then(() => {
        axiosClient.post("api/register", data.value)
            .then(response => {
                toast.success(response.data.message);
                router.push({name: "Login"});
            })
            .catch(error => {
                console.log(error.response.data);
                toast.error(error.response.data.message);
            })
    });
}
</script>

<template>
    <GuestLayout>
        <form @submit.prevent="register">
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">
                    Nome
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <CircleUserRound class="w-5 h-5 text-gray-400"/>
                    </div>
                    <input 
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        id="name" 
                        type="text" 
                        placeholder="Nome"
                        v-model="data.name"
                    >
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="email">
                    E-mail
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <AtSign class="w-5 h-5 text-gray-400"/>
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

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="password">
                    Senha
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <LockKeyhole class="w-5 h-5 text-gray-400"/>
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

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2" for="password">
                    Confirme sua senha
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <LockKeyhole class="w-5 h-5 text-gray-400"/>
                    </div>
                    <input 
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        id="c_password" 
                        type="password" 
                        placeholder="••••••••"
                        v-model="data.c_password"
                    >
                </div>
            </div>

            <button 
                type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 rounded-lg cursor-pointer
                hover:from-blue-700 hover:to-indigo-700 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
            >
                Registrar
            </button>
        </form>

        <div class="flex items-center my-6">
            <div class="flex-1 border-t border-gray-300"></div>
            <span class="px-4 text-sm text-gray-500">ou</span>
            <div class="flex-1 border-t border-gray-300"></div>
        </div>

        <div class="text-center">
            <p class="text-gray-600 text-sm">
                Já tem uma conta? 
                <button @click="router.push('/login')" class="text-blue-600 hover:text-blue-800 font-semibold cursor-pointer">
                    Logue-se
                </button>
            </p>
        </div>
    </GuestLayout>
</template>

<style scoped>
</style>