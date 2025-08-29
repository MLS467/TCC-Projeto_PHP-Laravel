<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class SearchForPatientByCPFController extends Controller
{
    public function __invoke(string $cpf)
    {
        try {
            $user = User::where('cpf', $cpf)->get();

            if ($user->isEmpty()) {
                throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Patient not found');
            }

            return response()->json([
                'status' => true,
                'message' => 'Patient found',
                'data' => $user
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }
}