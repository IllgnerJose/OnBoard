<script setup>
    import { Plane } from 'lucide-vue-next';
</script>

<template>
    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <!-- Header com gradiente -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-8 text-center">
                    <div class="inline-block p-3 bg-white rounded-full mb-4">
                        <Plane class="text-blue-600"/>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Bem-vindo!</h1>
                    <p class="text-blue-100">OnBoard</p>
                </div>

                <div class="p-8">
                    <RouterView/>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>
