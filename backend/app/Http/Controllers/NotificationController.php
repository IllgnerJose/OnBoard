<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->take(20)
            ->get();

        return $this->sendResponse($notifications, 'Notificações do usuário lidas com sucesso.');
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()
            ->notifications()
            ->findOrFail($id);
        
        $notification->markAsRead();

        return $this->sendResponse($notification, 'Notificação marcada como lida.');
    }

    public function markAllAsRead(Request $request)
    {
        $notifications = $request->user()->unreadNotifications;
        $notifications->markAsRead();

        return $this->sendResponse($notifications, 'Todas as notificações marcadas como lidas.');
    }

    public function unreadCount(Request $request)
    {
        $count = $request->user()->unreadNotifications()->count();
        
        return $this->sendResponse(['count' => $count], 'Contagem de notificações não lidas.');
    }
}