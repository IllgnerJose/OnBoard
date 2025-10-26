<?php 

namespace App\Services;
use App\Repositories\StatusRepository;
use Illuminate\Database\Eloquent\Collection;

class StatusService {
    public function __construct(
        protected StatusRepository $statusRepository,
    ){}

    public function index(): Collection
    {
        $statuses = $this->statusRepository->all();
        return $statuses;
    }

}