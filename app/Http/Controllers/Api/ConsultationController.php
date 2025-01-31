<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConsultationResource;
use App\Http\Resources\ConsultationResourceColletion;
use App\Models\Consultation;
use App\Http\Requests\UpdateConsultationRequest;
use Illuminate\Http\Request;

// tenho que fazer as relações com paciente

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ConsultationResourceColletion(Consultation::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Consultation::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Consultation $consultation)
    {
        return new ConsultationResource($consultation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(request $request, Consultation $consultation)
    {
        $consultation->update($request->all());
        return response()->json(["status" => true, "message" => "Consultation updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consultation $consultation)
    {
        $consultation->delete();
    }
}