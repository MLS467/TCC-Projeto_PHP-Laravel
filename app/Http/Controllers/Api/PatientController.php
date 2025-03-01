<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Http\Resources\PatientResourceCollection;
use App\Models\PatientModel as Patient;
use App\Models\User;

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
        return Patient::where('flag_triage', 1)->get()->load('user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        try {
            $id_user = $request->user_id;

            if (Patient::create($request->validated())) {
                User::find($id_user)->update(['flag' => '1']);
                return response()->json([
                    'status' => true,
                    'message' => 'Patient created successfully'
                ], 201);
            } else {
                throw new \Exception('Error creating patient');
            }
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