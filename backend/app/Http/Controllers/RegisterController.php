<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Services\RoleService;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\JsonResponse;
use App\Enums\UserRole;

class RegisterController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected RoleService $roleService,
    ){}

    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreUserRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $role = $this->roleService->getByName(UserRole::USER->name);

        if (is_null($role)) {
            return $this->sendError("Cargo " . UserRole::USER->name . " não encontrado.");
        }

        $validatedData["role_id"] = $role->id;

        $user = $this->userService->store($validatedData);
        $success = $this->userService->createToken($user);
        return $this->sendResponse($success, 'Usuario registrado com successo.');
    }
}
