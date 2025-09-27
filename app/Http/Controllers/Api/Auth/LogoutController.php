<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;

class LogoutController extends Controller
{
    public function __invoke(User $user)
    {

        try {
            if (auth()->user()->id != $user->id)
                throw new Exception('Não autorizado para fazer logout deste usuário', 403);

            if (auth()->user()->tokens()->delete())
                return response()->json(['message' => 'Logout realizado com sucesso'], 200);

            throw new Exception('Erro ao realizar logout', 500);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}