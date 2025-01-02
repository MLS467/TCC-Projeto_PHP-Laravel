<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class Nurse extends Crud
{
    protected $model = 'Nurse';

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
    public function store(Request $request)
    {
        return $this->storeGlobal($request, $this->model);
    }

    /**
     * Display the specified resource.
     */
    public function show(Nurse $nurse)
    {
        return $this->showGlobal($nurse, 'user');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nurse $nurse)
    {
        return $this->updateGlobal($request, $nurse);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nurse $nurse)
    {
        return $this->destroyGlobal($nurse);
    }
}