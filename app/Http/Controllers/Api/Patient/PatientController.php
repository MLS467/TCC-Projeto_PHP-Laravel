<?php

namespace App\Http\Controllers\Api\Patient;

use App\Exceptions\PatientException;
use App\Http\Controllers\Api\Abstract\Crud;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Http\Resources\PatientResourceCollection;
use App\Models\Bed;
use App\Models\PatientModel as Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PatientController extends Crud
{

    protected $model = 'PatientModel';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PatientResourceCollection(
            Patient::with('user')
                ->orderByDesc('created_at')
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        try {

            return DB::transaction(function () use ($request) {
                $patientData = $request->validated();
                $patientData['flag_consultation'] = 0;

                $patient = Patient::create($patientData);

                if (!$patient)
                    throw new PatientException('Erro ao criar paciente', 404);

                $user = User::find($patientData['user_id']);

                if (!$user)
                    throw new PatientException('Usuário não encontrado', 404);

                $user->update(['flag' => 1]);

                if ($patientData['patient_condition'] === 'critical') {
                    $bed = Bed::where('user_id', '=', null)
                        ->where('status_bed', '=', false)
                        ->first();

                    if (!$bed) {
                        return response()->json([
                            'status' => true,
                            'message' => 'Não há mais leitos, espere a liberação para proseguir',
                            'data' => $patient
                        ], 200);
                    }

                    $bed->user_id = $patient->user->id;
                    $bed->status_bed = true;
                    $bed->updated_at = Carbon::now();
                    $bed->save();
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Paciente criado com sucesso',
                    'data' => $patient
                ], 201);
            });
        } catch (PatientException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao criar paciente',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return new PatientResource($patient->load('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        return $this->updateGlobal($request, $patient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient): JsonResponse
    {
        try {

            $bed_exists = Bed::where('user_id', $patient->user->id);

            if ($bed_exists->exists()) {
                $bed = $bed_exists->first();
                $bed->user_id = null;
                $bed->status_bed = false;
                $bed->updated_at = Carbon::now();
                $bed->save();
            }

            $patient->user->update(['flag' => 40028922]);

            $patient->delete();

            return response()->json([
                'status' => true,
                'message' => 'Paciente deletado com sucesso'
            ], 200);
        } catch (PatientException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao deletar paciente',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}