<?php 

namespace App\Repositories;
use App\Models\Destination;
use Illuminate\Database\Eloquent\Collection;

class DestinationRepository {
    public function __construct(
        protected Destination $destinationModel,
    ){}

    public function all(): Collection
    {
        return $this->destinationModel->all();
    }
}