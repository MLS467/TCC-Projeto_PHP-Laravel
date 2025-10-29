<?php

namespace App\Http\Controllers\Api\Bed;

use App\Http\Controllers\Controller;
use App\Models\Bed;
use App\Models\User;
use Illuminate\Http\Request;

class JoinManualBedFromPatient extends Controller
{

    public function __invoke(Request $request)
    {

        $this->validate_ids($request);

        $user_id = $request->user_id;
        $bed_id = $request->bed_id;

        $user = User::find($user_id);
        $bed  = Bed::find($bed_id);
        $bed_is_occuped = Bed::where('user_id', $user_id)->first();

        if ($bed_is_occuped) {
            return response()->json([
                'message' => 'O paciente já está associado a um leito.'
            ], 400);
        }


        if (!$user) {
            return response()->json([
                'message' => 'Usuário não encontrado.'
            ], 404);
        }

        if (!$bed) {
            return response()->json([
                'message' => 'Leito não encontrado.'
            ], 404);
        }

        if (isset($bed->user_id)) {
            return response()->json([
                'message' => 'Leito já está ocupado.'
            ], 400);
        }

        $bed->user_id = $user->id;
        $bed->status_bed = true;
        $bed->save();
        return response()->json([
            'message' => 'Leito associado ao paciente com sucesso.',
            'bed' => $bed
        ], 200);
    }

    private function validate_ids(Request $request)
    {
        $validation = [
            'user_id' => 'required | integer',
            'bed_id' => 'required | integer'
        ];

        $message = [
            'use.required' => "O campo user_id é obrigatório.",
            'bed.required' => "O campo bed_id é obrigatório.",
            'user_id.integer' => "O campo user_id deve ser um número inteiro.",
            'bed_id.integer' => "O campo bed_id deve ser um número inteiro."
        ];


        $request->validate($validation, $message);
    }
}