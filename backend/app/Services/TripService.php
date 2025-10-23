<?php 

namespace App\Services;
use App\Repositories\TripRepository;

class TripService {
    public function __construct(
        protected TripRepository $tripRepository;
    ){}
}