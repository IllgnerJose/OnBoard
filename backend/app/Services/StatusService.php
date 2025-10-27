<?php 

namespace App\Services;
use App\Models\Status;
use App\Repositories\StatusRepository;
use Illuminate\Database\Eloquent\Collection;

class StatusService {
    public function __construct(
        protected StatusRepository $statusRepository,
    ){}

    public function getByName(string $name): ?Status
    {
        return $this->statusRepository->getByName($name);
    }
    
    public function index(): Collection
    {
        $statuses = $this->statusRepository->all();
        return $statuses;
    }

}