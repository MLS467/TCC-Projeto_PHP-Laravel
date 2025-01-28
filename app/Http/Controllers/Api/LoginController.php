<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginResquest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginResquest $request)
    {
        ['email' => $email, 'password' => $password] = $request->validated();

        try {
            if (!$email || !$password)
                throw new \Exception('Email e senha são obrigatórios');

            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $user = Auth::user();
                $token = $request->user()->createToken('Token-Valido')->plainTextToken;
                return response()->json(['user' => $user, 'token' => $token], 200);
            } else
                throw new \Exception('Senha ou email inválidos');
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }


    public function logout(User $user)
    {
        try {
            $user->Tokens()->delete();
            return response()->json(['message' => 'Logout realizado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }
}