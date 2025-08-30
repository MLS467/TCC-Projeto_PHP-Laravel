<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Models\User;

class LogoutController extends Controller
{
    public function __invoke(User $user)
    {
        if ($user->tokens()->delete())
            return response()->json(['message' => 'Logout realizado com sucesso'], 200);

        throw new AuthException('Erro ao realizar logout', 500);
    }
}