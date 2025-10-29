<?php

namespace App\Http\Controllers\Api\Bed;

use App\Http\Controllers\Controller;
use App\Models\PatientModel;

class PatientForBed extends Controller
{
    public function __invoke()
    {
        $patients = PatientModel::with('user')
            ->where('flag_triage', 1)
            ->where('flag_consultation', 0)
            ->get();


        return response()->json($patients, 200);
    }
}