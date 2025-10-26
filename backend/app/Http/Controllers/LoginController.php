<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(
        protected UserService $userService,
    ){}
    
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();
            $success = $this->userService->createToken($user);
            return $this->sendResponse($success, 'Usuario logado com successo.');

        } else{ 
            return $this->sendError('Login nao autorizado.', ['error'=>'Unauthorized'], 401);

        }
    }
}
