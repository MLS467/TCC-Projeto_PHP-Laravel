<?php

namespace App\Http\Controllers\Api\Mail;

use App\Http\Controllers\Controller;
use App\Mail\AtendeBemMail as MailAtendeBemMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AtendeBemMail extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validar o email
        $request->validate([
            'email' => 'required|email'
        ]);

        // Buscar o usuário pelo email
        $user = User::where('email', '=', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não encontrado com este e-mail.'
            ], 404);
        }

        // Gerar token e salvar no usuário
        $token = Str::random(60);

        // Salvar o token no usuário (adicione uma coluna reset_token na tabela users)
        $user->reset_token = $token;
        $user->reset_token_expires = now()->addHours(2); // Token expira em 2h
        $user->save();

        // Preparar os dados para o email
        $dados = [
            'name' => $user->name,
            'email' => $user->email,
            'reset_token' => $token,
            'reset_url' => url('/reset-password?token=' . $token . '&email=' . $user->email)
        ];

        try {
            // Enviar o email
            Mail::to($user->email)->send(new MailAtendeBemMail($dados));

            return response()->json([
                'success' => true,
                'message' => 'E-mail enviado com sucesso!',
                'user_found' => $user->name
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao enviar e-mail: ' . $e->getMessage()
            ], 500);
        }
    }
}