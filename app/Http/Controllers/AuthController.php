<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function login(AuthRequest $request, AuthService $authService)
    {
        $result = $authService->login($request->validated());
        return response()->json($result, 200);
    }


    public function logout(Request $request, AuthService $authService)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'No hay sesión'], 401);
        }
        $result = $authService->logout($user);

        return response()->json($result, 200);
    }
}
