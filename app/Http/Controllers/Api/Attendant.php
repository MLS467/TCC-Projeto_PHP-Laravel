<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AttendantStoreRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\Attendant as ModelsAttendant;
use Illuminate\Http\Request;

class Attendant extends Crud
{
    protected $model = 'Attendant';

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
    public function store(AttendantStoreRequest $request)
    {
        return $this->storeGlobal($request, $this->model);
    }

    /**
     * Display the specified resource.
     */
    public function show(ModelsAttendant $attendant)
    {
        return $this->showGlobal($attendant, 'user');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, ModelsAttendant $attendant)
    {
        return $this->updateGlobal($request, $attendant);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelsAttendant $attendant)
    {

        return $this->destroyGlobal($attendant);
    }
}