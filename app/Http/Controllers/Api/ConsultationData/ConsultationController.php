<?php

namespace App\Http\Controllers\Api\ConsultationData;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConsultationResource;
use App\Http\Resources\ConsultationResourceColletion;
use App\Models\Consultation;
use App\Http\Requests\UpdateConsultationRequest;
use App\Http\Requests\StoreConsultationRequest;
use App\Models\PatientModel;
use Illuminate\Http\Request;


class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return new ConsultationResourceColletion(Consultation::all());
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving consultations',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConsultationRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $consultation = Consultation::create($validatedData);
            PatientModel::where('id', $validatedData['patient_id'])
                ->update(['flag_consultation' => 1]);
            return response()->json([
                'status' => true,
                'message' => 'Consultation created successfully',
                'data' => new ConsultationResource($consultation)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error creating consultation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Consultation $consultation)
    {
        try {
            return response()->json([
                'status' => true,
                'data' => new ConsultationResource($consultation)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error retrieving consultation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConsultationRequest $request, Consultation $consultation)
    {
        try {
            $consultation->update($request->validated());
            return response()->json([
                'status' => true,
                'message' => 'Consultation updated successfully',
                'data' => new ConsultationResource($consultation)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error updating consultation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultation $consultation)
    {
        try {
            $consultation->delete();
            return response()->json([
                'status' => true,
                'message' => 'Consultation deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error deleting consultation',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}