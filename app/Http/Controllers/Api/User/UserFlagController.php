<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;

class UserFlagController extends Controller
{
    public function __invoke()
    {
        try {
            return User::where([
                ['flag', '=', '0'],
                ['role', '=', 'patient']
            ])
                ->orderBy('created_at', 'asc')
                ->get();
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching flagged users',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}