<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __construct(
        protected UserService $userService,
    ){}

    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->store($request->validated());
        $success = $this->userService->createToken($user);
        return $this->sendResponse($success, 'Usuario registrado com successo.');
    }
}
