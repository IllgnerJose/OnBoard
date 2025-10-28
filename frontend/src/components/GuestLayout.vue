<script setup>
</script>

<template>
    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
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

                <div class="p-8">
                    <RouterView/>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>
