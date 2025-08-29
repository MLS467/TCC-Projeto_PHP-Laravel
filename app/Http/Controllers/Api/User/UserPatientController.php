<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;

class UserPatientController extends Controller
{
    public function __invoke()
    {
        try {
            return User::where('role', 'patient')->get();
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching patient users',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}