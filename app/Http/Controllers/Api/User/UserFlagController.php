<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Exception;

use function Symfony\Component\Clock\now;

class UserFlagController extends Controller
{
    public function __invoke()
    {
        try {
            $data = User::where([
                ['flag', '=', '0'],
                ['role', '=', 'patient']
            ])
                ->orderBy('updated_at', 'asc')
                ->get();

            return $data;
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error fetching flagged users',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}