<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
    public function store(Request $request)
    {
        return $this->storeGlobal($request, $this->model);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendant $attendant)
    {
        return $this->showGlobal($attendant, 'user');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendant $attendant)
    {
        return $this->updateGlobal($request, $attendant);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendant $attendant)
    {
        return $this->destroyGlobal($attendant);
    }
}