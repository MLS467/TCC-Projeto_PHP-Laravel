<?php

namespace App\Http\Controllers\Api\Bed;

use App\Http\Controllers\Controller;
use App\Models\Bed;
use Illuminate\Http\Request;

class SeparateBedFromPatient extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate(
            [
                'id' => 'required|integer'
            ],
            [
                'id.required' => 'O id é obrigatório.',
                'id.integer' => 'O id deve ser do tipo inteiro.'
            ]
        );

        $id = $request->id;

        if (!$id) {
            return response()->json(['message' => 'identificador inválido.'], 401);
        }

        $bed = Bed::find($id);

        if (!$bed) {
            return response()->json(['message' => 'Leito não encontrado'], 404);
        }

        $bed->user_id = null;
        $bed->status_bed = false;
        $bed->save();
        return response()->json(['message' => 'Paciente desvinculado com sucesso!'], 200);
    }
}