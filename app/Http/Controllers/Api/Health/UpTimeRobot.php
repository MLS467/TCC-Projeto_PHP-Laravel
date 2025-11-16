<?php

namespace App\Http\Controllers\Api\Health;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UpTimeRobot extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            DB::connection()->getPdo();
            return response()->json([
                'alive' => true,
                'db'    => 'ok'
            ], 200);
        } catch (Exception $e) {
            $message = env('APP_ENV') === 'local'
                ? $e->getMessage()
                : 'database connection failed';

            return response()->json([
                'alive'  => false,
                'db'     => 'fail',
                'error'  => $message
            ], 500);
        }
    }
}