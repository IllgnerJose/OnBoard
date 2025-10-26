<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Trip;

class TripPolicy
{
    public function updateStatus(User $user, Trip $trip): bool
    {
        return $user->isAdmin();
    }
}
