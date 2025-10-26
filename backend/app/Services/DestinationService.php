<?php 

namespace App\Services;
use App\Repositories\DestinationRepository;
use Illuminate\Database\Eloquent\Collection;

class DestinationService {
    public function __construct(
        protected DestinationRepository $destinationRepository,
    ){}

    public function index(): Collection
    {
        $destinations = $this->destinationRepository->all();
        return $destinations;
    }

}