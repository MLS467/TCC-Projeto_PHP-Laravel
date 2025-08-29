<?php

namespace App\Http\Controllers\Api\Record;

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

        return response()->json([
            'message' => 'Failed to create medical record'
        ], 402);
    }

    /**
     * Display the specified resource.
     */
    public function show(request $request)
    {
        try {
            $result = MedicalRecord::findOrfail($request->id);

            if (!$result) {
                return response()->json([
                    'message' => 'Medical record not found'
                ], 404);
            }

            return response()->json([
                'data' => $result
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Medical record not found'
            ], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}