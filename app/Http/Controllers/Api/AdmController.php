<?php

namespace App\Http\Controllers\Api;

use App\Models\Adm;
use App\Models\User;
use Illuminate\Http\Request;

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
    public function store(Request $request)
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
    public function update(Request $request, Adm $adm)
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