<?php 

namespace App\Repositories;
use App\Models\User;

class UserRepository 
{
    public function __construct(
        protected User $userModel,
    ){}

    public function create(array $validatedData): User
    {
        return $this->userModel->create($validatedData);
    }
}