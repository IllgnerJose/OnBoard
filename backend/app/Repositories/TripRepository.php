<?php 

namespace App\Repositories;
use App\Models\Trip;

class TripRepository {
    public function __construct(
        protected Trip $tripModel;
    ){}
}