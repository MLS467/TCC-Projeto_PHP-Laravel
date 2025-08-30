<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginResquest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginResquest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $request->user()->createToken('Token-Valido')->plainTextToken;
            return response()->json(['user' => $user, 'token' => $token], 200);
        } else
            throw new AuthException('Senha ou email inválidos');
    }
}