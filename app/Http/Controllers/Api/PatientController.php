<?php

namespace App\Http\Controllers\Api;

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

    public function patientCompleted()
    {
        return Patient::where('flag_triage', 1)
            ->where('flag_consultation', 0) // Adiciona filtro para mostrar apenas quando flag_consultition = 0
            ->orderByRaw("CASE 
        WHEN patient_condition = 'critical' THEN 1
        WHEN patient_condition = 'serious' THEN 2
        WHEN patient_condition = 'moderate' THEN 3
        WHEN patient_condition = 'mild' THEN 4
        ELSE 5
    END")
            ->orderBy('created_at', 'asc')
            ->get()
            ->load('user');
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

                if (!$patient) {
                    throw new \Exception('Error creating patient');
                }

                $user = User::find($patientData['user_id']);
                if (!$user) {
                    throw new \Exception('User not found');
                }

                $user->update(['flag' => 1]);

                return response()->json([
                    'status' => true,
                    'message' => 'Patient created and user updated successfully',
                    'data' => $patient
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 400);
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
    public function destroy(Patient $patient)
    {
        return $this->destroyGlobal($patient);
    }
}