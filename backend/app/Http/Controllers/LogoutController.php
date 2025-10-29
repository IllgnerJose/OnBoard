<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();
    
        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }
}
