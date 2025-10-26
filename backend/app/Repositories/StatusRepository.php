<?php 

namespace App\Repositories;
use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;

class StatusRepository {
    public function __construct(
        protected Status $statusModel,
    ){}

    public function all(): Collection
    {
        return $this->statusModel->all();
    }
}