<?php

namespace App\Http\Controllers\Api\Nurse;

use App\Http\Controllers\Api\Abstract\Crud;
use App\Http\Requests\StoreNurseRequest;
use App\Http\Requests\UpdateNurseRequest;
use App\Models\Nurse as ModelsNurse;

class Nurse extends Crud
{
    protected $model = 'nurse';

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
    public function store(StoreNurseRequest $request)
    {

        return $this->storeGlobal($request, $this->model);
    }

    /**
     * Display the specified resource.
     */
    public function show(ModelsNurse $nurse)
    {

        return $this->showGlobal($nurse, 'user');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNurseRequest $request, ModelsNurse $nurse)
    {
        return $this->updateGlobal($request, $nurse);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelsNurse $nurse)
    {
        return $this->destroyGlobal($nurse);
    }
}
