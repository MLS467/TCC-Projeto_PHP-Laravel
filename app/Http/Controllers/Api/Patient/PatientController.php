<?php

namespace App\Http\Controllers\Api\Patient;

use App\Exceptions\PatientException;
use App\Http\Controllers\Api\Abstract\Crud;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Http\Resources\PatientResourceCollection;
use App\Models\PatientModel as Patient;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PatientController extends Crud
{

    protected $model = 'PatientModel';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PatientResourceCollection(Patient::with('user')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
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

            return response()->json([
                'status' => true,
                'message' => 'Patient created and user updated successfully',
                'data' => $patient
            ], 201);
        });
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
    public function destroy(Patient $patient)
    {
        return $this->destroyGlobal($patient);
    }
}