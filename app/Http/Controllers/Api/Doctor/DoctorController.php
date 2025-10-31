<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Api\Abstract\Crud;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Http\Requests\StoreDoctorRequest;

class DoctorController extends Crud
{
    protected $model = 'Doctor';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->indexGlobal($this->model, 'user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request)
    {
        return $this->storeGlobal($request, $this->model);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return $this->showGlobal($doctor, 'user');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        return $this->updateGlobal($request, $doctor);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        return $this->destroyGlobal($doctor);
    }
}