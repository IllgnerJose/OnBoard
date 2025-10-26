<?php 

namespace App\Repositories;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Collection;

class TripRepository {
    public function __construct(
        protected Trip $tripModel,
    ){}

    public function all(): Collection
    {
        return $this->tripModel->all();
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