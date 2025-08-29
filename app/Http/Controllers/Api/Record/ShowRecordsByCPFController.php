<?php

namespace App\Http\Controllers\Api\Record;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class ShowRecordsByCPFController extends Controller
{
    public function __invoke(Request $request, $cpf)
    {
        return response()->json([
            'data' => MedicalRecord::where('cpf', $cpf)
                ->get([
                    'id',
                    'full_name',
                    'created_at',
                ])
        ]);
    }
}