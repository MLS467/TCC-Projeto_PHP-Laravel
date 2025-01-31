<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AdmStoreRequest;
use App\Http\Requests\AdmUpdateRequest;
use App\Models\Adm;

class AdmController extends Crud
{

    protected $model = 'Adm';

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
    public function store(AdmStoreRequest $request)
    {
        return $this->storeGlobal($request, $this->model);
    }

    /**
     * Display the specified resource.
     */
    public function show(Adm $adm)
    {
        return $this->showGlobal($adm, 'user');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdmUpdateRequest $request, Adm $adm)
    {
        return $this->updateGlobal($request, $adm);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adm $adm)
    {
        return $this->destroyGlobal($adm);
    }
}