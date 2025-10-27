<?php 

namespace App\Services;
use App\Repositories\TripRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Collection;
use App\Enums\TripStatus;
use App\Exceptions\AlreadyApprovedTripException;

class TripService {
    public function __construct(
        protected TripRepository $tripRepository,
    ){}

    public function index(): Collection
    {
        if (Auth::user()->isAdmin()) {
            $trips = $this->tripRepository->all();
        } else {
            $trips = $this->tripRepository->getUserTrips();
        }
        
        return $trips;
    }

    public function store(array $validatedData): Trip 
    {
        $trip = $this->tripRepository->create($validatedData);
        return $trip;
    }

    public function show(int $id): ?Trip 
    {
        $trip = $this->tripRepository->find($id);
        return $trip;
    }

    public function update(array $validatedData, Trip $trip): Trip
    {
        if ($trip->status->name == TripStatus::APPROVED->name) {
            throw new AlreadyApprovedTripException();
        }

        $trip = $this->tripRepository->update($validatedData, $trip);
        return $trip;
    }

}