<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

class LogoutController extends Controller
{
    public function __invoke(User $user)
    {
        try {
            $user->Tokens()->delete();
            return response()->json(['message' => 'Logout realizado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }
}