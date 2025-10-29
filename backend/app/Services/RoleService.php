<?php 

namespace App\Services;
use App\Models\Role;
use App\Repositories\RoleRepository;

class RoleService 
{
    public function __construct(
        protected RoleRepository $roleRepository,
    ){}

    public function getByName(string $name): ?Role
    {
        return $this->roleRepository->getByName($name);
    }
}