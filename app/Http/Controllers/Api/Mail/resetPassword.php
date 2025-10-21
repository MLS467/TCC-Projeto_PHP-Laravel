<?php

namespace App\Http\Controllers\Api\Mail;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ResetPassword extends Controller
{
    /**
     * Exibe o formulário de reset de senha
     */
    public function showResetForm(Request $request)
    {
        // Verifica se os parâmetros token e email estão presentes
        if (!$request->has(['token', 'email'])) {
            abort(404, 'Link de reset inválido');
        }

        return view('AtendeBemEmail.reset-password', [
            'token' => $request->token,
            'email' => $request->email
        ]);
    }

    /**
     * Processa o reset de senha
     */
    public function resetPassword(Request $request): RedirectResponse|View
    {
        // Validação dos dados
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('token', $request->token)
                ->with('email', $request->email);
        }

        try {
            // Busca o usuário
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return redirect()->back()
                    ->withErrors(['email' => 'Usuário não encontrado'])
                    ->withInput()
                    ->with('token', $request->token)
                    ->with('email', $request->email);
            }

            // TODO: Validar token de reset (implementar verificação de token)

            // Atualiza a senha
            $user->password = Hash::make($request->password);
            $user->save();

            // Redireciona para página de sucesso
            return view('AtendeBemEmail.reset-success');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Erro interno do servidor: ' . $e->getMessage()])
                ->withInput()
                ->with('token', $request->token)
                ->with('email', $request->email);
        }
    }
}