<?php

namespace App\Http\Controllers\Api\Mail;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AtendeBemMail extends Controller
{
    public function sendTokenEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', '=', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não encontrado com este e-mail.'
            ], 404);
        }

        $token = Str::random(60);

        $user->reset_token = $token;
        $user->reset_token_expires = now()->addHours(2); // Token expira em 2h
        $user->save();

        return response()->json([
            'success' => true,
            'email' => $user->email,
            'reset_url' => '?token=' . $token . '&email=' . $user->email
        ]);
    }
}