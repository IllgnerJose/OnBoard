<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\DatabaseNotification as BaseDatabaseNotification;

class Notification extends BaseDatabaseNotification
{
    use HasFactory;

    protected $fillable = [
        "type",
        "notifiable_type ", 
        "notifiable_id",
        "data",
        "created_at",
        "updated_at",
        "read_at",
    ];
}
