<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TripStatusChanged extends Notification
{
    use Queueable;

    private $trip;
    private $status;

    public function __construct($trip, $status)
    {
        $this->trip = $trip;
        $this->status = $status;
    }

    public function via()
    {
        return ['database'];
    }

    public function toDatabase()
    {
        $statusText = $this->status === 'APPROVED' ? 'aprovado' : 'cancelado';
        
        return [
            'trip_id' => $this->trip->id,
            'status' => $this->status,
            'destination' => $this->trip->destination->city . ' - ' . $this->trip->destination->state,
            'message' => "Seu pedido de viagem para {$this->trip->destination->city} foi {$statusText}!",
            'departure_date' => $this->trip->departure_date->format("d/m/Y"),
            'return_date' => $this->trip->return_date->format("d/m/Y"),
        ];
    }
}