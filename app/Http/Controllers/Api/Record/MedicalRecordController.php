<?php

namespace App\Http\Controllers\Api\Record;

use App\Exceptions\MedicalException;
use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (MedicalRecord::create($request->all())) {
            return response()->json([
                'message' => 'Medical record created successfully',
                'data' => MedicalRecord::latest()->first()
            ], 201);
        }

        throw new MedicalException('Falha ao criar novo Histórico Médico', 500);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $result = MedicalRecord::findOrfail($id);

        if (!$result)
            throw new MedicalException('Histórico Médico não encontrado', 404);

        return response()->json([
            'data' => $result
        ], 200);
    }
}