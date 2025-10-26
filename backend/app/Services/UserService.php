<?php 

namespace App\Services;
use App\Repositories\UserRepository;
use App\Models\User;

class UserService 
{
    public function __construct(
        protected UserRepository $userRepository,
    ){}

    public function store(array $validatedData): User
    {
        $user = $this->userRepository->create($validatedData);
        return $user;
    }

    public function createToken(User $user): array
    {
        $success['token'] = $user->createToken('onboard-token')->plainTextToken;
        $success['name'] = $user->name;
        $success['is_admin'] = $user->isAdmin();

        return $success;
    }
}