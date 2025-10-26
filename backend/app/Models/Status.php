<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\TripStatus;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
    ];

}
