<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(array $data)
    {

        $user = User::where("email", $data["email"])->first();

        if (!$user || ! Hash::check($data["password"], $user->password)) {
            throw ValidationException::withMessages([
                "email" => ["El usuario o password no son válidos."],
            ]);
        }

        $user->tokens()->delete();

        $token = $user->createToken("auth_token")->plainTextToken;

        return [
            "token" => $token,
            "name" => $user->name
        ];
    }

    public function logout($user)
    {
        $user->currentAccessToken()->delete();
        return ['message' => 'Sesión cerrada'];
    }
}
