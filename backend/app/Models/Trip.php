<?php

namespace App\Models;

use App\Policies\TripPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[UsePolicy(TripPolicy::class)]
class Trip extends Model
{
    use HasFactory;
    protected $fillable = [
        'departure_date',
        'return_date',
        'destination_id',
        'status_id',
        'user_id',
    ];

    protected $with = ['user', 'destination', 'status'];

    protected function casts(): array
    {
        return [
            'departure_date' => 'date',
            'return_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
