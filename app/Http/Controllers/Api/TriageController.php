<?php

namespace App\Http\Controllersz\Api;

use App\Http\Controllers\Controller;
use App\Models\Triage;
use App\Http\Requests\StoreTriageRequest;
use App\Http\Requests\UpdateTriageRequest;

class TriageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTriageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Triage $triage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTriageRequest $request, Triage $triage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Triage $triage)
    {
        //
    }
}