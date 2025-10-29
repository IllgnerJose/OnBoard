<?php 

namespace App\Repositories;
use App\Models\Role;

class RoleRepository {
    public function __construct(
        protected Role $roleMOdel,
    ){}

    public function getByName(string $name): ?Role
    {
        return $this->roleMOdel->where('name', $name)->first();
    }
}