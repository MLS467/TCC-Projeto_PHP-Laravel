<?php

namespace App\Http\Controllers\Api\ConsultationData;

use App\Exceptions\ConsultationException;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConsultationResource;
use App\Models\Consultation;
use App\Http\Requests\UpdateConsultationRequest;
use App\Http\Requests\StoreConsultationRequest;
use App\Models\PatientModel;
use Illuminate\Support\Facades\DB;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $newConsutation = Consultation::all();
        if (!$newConsutation->isEmpty()) {
            return response()->json([
                'status' => true,
                'data' => $newConsutation
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Erro em solicitar dados de consulta.'
        ], 500);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreConsultationRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $validatedData = $request->validated();

                $consultation = Consultation::create($validatedData);

                $updatePatientFlag = PatientModel::where('id', $validatedData['patient_id'])
                    ->update(['flag_consultation' => 1]);

                if (!$updatePatientFlag) {
                    throw new ConsultationException('Erro ao atualizar flag do paciente.', 500);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Consultation created successfully',
                    'data' => new ConsultationResource($consultation)
                ], 201);
            });
        } catch (\Exception $ConsultationError) {
            if (env("APP_ENV") == 'local') {

                return response()->json([
                    'status' => false,
                    'message' => $ConsultationError->getMessage(),
                    'error' => $ConsultationError->getTraceAsString()
                ], 500);
            }

            throw new ConsultationException($ConsultationError->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Consultation $consultation)
    {
        $data = new ConsultationResource($consultation);

        if (!$data->isEmpty()) {
            return response()->json([
                'status' => true,
                'data' => $data
            ], 200);
        }

        throw new ConsultationException('Erro ao buscar consulta.', 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConsultationRequest $request, Consultation $consultation)
    {

        $validate_data = $request->validated();

        if ($consultation->update($validate_data)) {
            return response()->json([
                'status' => true,
                'message' => 'Consultation updated successfully',
                'data' => new ConsultationResource($consultation)
            ], 200);
        }

        throw new ConsultationException('Erro ao atualizar consulta.', 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultation $consultation)
    {

        if ($consultation->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'Consultation deleted successfully'
            ], 200);
        }

        throw new ConsultationException('Erro ao deletar consulta.', 500);
    }
}