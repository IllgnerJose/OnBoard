<script setup>

import { ref, onMounted, computed } from 'vue';
import { Bell, Check } from 'lucide-vue-next';
import axiosClient from '@/axios';
import { useToast } from 'vue-toastification';

const toast = useToast();
const notifications = ref([]);
const showDropdown = ref(false);
const loading = ref(false);

const unreadCount = computed(() => 
    notifications.value.filter(n => !n.read_at).length
);

async function loadNotifications() {
    loading.value = true;
    try {
        const response = await axiosClient.get('/api/notifications');
        notifications.value = response.data.data;
    } catch (error) {
        toast.error(error.response.data.message);
    } finally {
        loading.value = false;
    }
}

async function markAsRead(notificationId) {
    try {
        await axiosClient.put(`/api/notifications/${notificationId}/read`);
        const notification = notifications.value.find(n => n.id === notificationId);
        if (notification) {
            notification.read_at = new Date().toISOString();
        }
    } catch (error) {
        toast.error(error.response.data.message);
    }
}

async function markAllAsRead() {
    try {
        await axiosClient.put('/api/notifications/mark-all-read');
        notifications.value.forEach(n => {
            if (!n.read_at) {
                n.read_at = new Date().toISOString();
            }
        });
    } catch (error) {
        toast.error(error.response.data.message);
    }
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffInSeconds = Math.floor((now - date) / 1000);

    if (diffInSeconds < 60) return 'Agora';
    if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} min atrás`;
    if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)}h atrás`;
    if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)} dias atrás`;
    
    return date.toLocaleDateString('pt-BR');
}

function handleClickOutside(event) {
    const dropdown = document.getElementById('notification-dropdown');
    if (dropdown && !dropdown.contains(event.target)) {
        showDropdown.value = false;
    }
}

onMounted(() => {
    loadNotifications();
    
    const interval = setInterval(loadNotifications, 30000);
    
    document.addEventListener('click', handleClickOutside);
    
    return () => {
        clearInterval(interval);
        document.removeEventListener('click', handleClickOutside);
    };
});
</script>

<template>
    <div class="relative" id="notification-dropdown">
        <button 
            @click.stop="showDropdown = !showDropdown"
            class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full transition"
            title="Notificações"
        >
            <Bell class="w-6 h-6" />
            <span 
                v-if="unreadCount > 0"
                class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold animate-pulse"
            >
                {{ unreadCount > 9 ? '9+' : unreadCount }}
            </span>
        </button>

        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1"
        >
            <div 
                v-if="showDropdown"
                class="absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-2xl border border-gray-200 z-50"
                @click.stop
            >
                <!-- Header -->
                <div class="p-4 border-b border-gray-200 flex items-center justify-between bg-gradient-to-r from-blue-600 to-indigo-600 rounded-t-lg">
                    <h3 class="font-semibold text-white flex items-center gap-2">
                        <Bell class="w-5 h-5" />
                        Notificações
                    </h3>
                    <button 
                        v-if="unreadCount > 0"
                        @click="markAllAsRead"
                        class="text-sm text-white hover:text-gray-200 transition flex items-center gap-1"
                    >
                        <Check class="w-4 h-4" />
                        Marcar todas como lidas
                    </button>
                </div>

                <!-- Lista de Notificações -->
                <div class="max-h-96 overflow-y-auto">
                    <!-- Loading -->
                    <div v-if="loading" class="p-8 text-center">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                    </div>

                    <!-- Vazio -->
                    <div 
                        v-else-if="notifications.length === 0"
                        class="p-8 text-center text-gray-500"
                    >
                        <Bell class="w-12 h-12 mx-auto mb-2 text-gray-300" />
                        <p>Nenhuma notificação</p>
                    </div>

                    <!-- Notificações -->
                    <div
                        v-else
                        v-for="notification in notifications"
                        :key="notification.id"
                        @click="markAsRead(notification.id)"
                        :class="[
                            'p-4 border-b border-gray-100 cursor-pointer transition duration-200',
                            !notification.read_at 
                                ? 'bg-blue-50 hover:bg-blue-100' 
                                : 'hover:bg-gray-50'
                        ]"
                    >
                        <div class="flex items-start gap-3">
                            <!-- Indicador de não lida -->
                            <div 
                                :class="[
                                    'w-2 h-2 rounded-full mt-2 flex-shrink-0',
                                    !notification.read_at ? 'bg-blue-600' : 'bg-gray-300'
                                ]"
                            />
                            
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 break-words">
                                    {{ notification.data.message }}
                                </p>
                                
                                <div v-if="notification.data.destination" class="mt-2 text-xs text-gray-600 space-y-1">
                                    <p>📍 {{ notification.data.destination }}</p>
                                    <p>📅 {{ notification.data.departure_date }} → {{ notification.data.return_date }}</p>
                                </div>
                                
                                <p class="text-xs text-gray-500 mt-2">
                                    {{ formatDate(notification.created_at) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-3 border-t border-gray-200 text-center">
                    <button 
                        @click="showDropdown = false"
                        class="text-sm text-blue-600 hover:text-blue-800 font-medium"
                    >
                        Fechar
                    </button>
                </div>
            </div>
        </Transition>
    </div>
</template>