<?php 

namespace App\Repositories;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class TripRepository {
    public function __construct(
        protected Trip $tripModel,
    ){}

    public function all(): Collection
    {
        return $this->tripModel->all();
    }

    public function getUserTrips(): Collection
    {
        return $this->tripModel
            ->where('user_id', Auth::user()->id)
            ->get();
    }

    public function create(array $validatedData): Trip 
    {
        return $this->tripModel->create($validatedData);
    }

    public function find(int $id): Trip 
    {
        return $this->tripModel->find($id);
    }

    public function update(array $validatedData, Trip $trip): Trip 
    {
        $trip->update($validatedData);
        return $trip->refresh();
    }
}