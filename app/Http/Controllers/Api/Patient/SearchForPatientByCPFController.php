<?php

namespace App\Http\Controllers\Api\Patient;

use App\Exceptions\PatientException;
use App\Http\Controllers\Controller;
use App\Models\User;

class SearchForPatientByCPFController extends Controller
{
    public function __invoke(string $cpf)
    {
        $user = User::where('cpf', $cpf)->get();

        if (!$user->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'Patient found',
                'data' => $user
            ], 200);
        }

        throw new PatientException('Paciente não encontrado', 404);
    }
}