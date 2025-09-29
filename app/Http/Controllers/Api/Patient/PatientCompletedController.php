<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Models\PatientModel;

class PatientCompletedController extends Controller
{
    public function __invoke()
    {
        return PatientModel::where('flag_triage', 1)
            ->where('flag_consultation', 0) // Adiciona filtro para mostrar apenas quando flag_consultition = 0
            ->orderByRaw("CASE 
                            WHEN patient_condition = 'critical' THEN 1
                            WHEN patient_condition = 'serious' THEN 2
                            WHEN patient_condition = 'moderate' THEN 3
                            WHEN patient_condition = 'mild' THEN 4
                            ELSE 5
                        END")
            ->orderBy('created_at', 'asc')
            ->get()
            ->load('user');
    }
}