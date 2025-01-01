<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        ['email' => $email, 'password' => $password] = $request->all();

        try {
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $user = Auth::user();
                $token = $request->user()->createToken('Token-Valido')->plainTextToken;
                return response()->json(['user' => $user, 'token' => $token], 200);
            } else
                throw new \Exception('Unauthorized');
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