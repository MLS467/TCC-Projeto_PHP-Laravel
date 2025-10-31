<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attendant;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Nurse;
use App\Models\PatientModel;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user_value_total = User::count();
        $records_value_total = MedicalRecord::count('id');
        $triage_pending_total = PatientModel::where('flag_triage', '=', 0)->count();
        $consultation_pending_total = PatientModel::where('flag_triage', 1)
            ->where('flag_consultation', 0)
            ->count();

        $doctors = Doctor::count('*');
        $nurses = Nurse::count('*');
        $attendants = Attendant::count('*');

        $values = [
            'consultation_pending_total' => $consultation_pending_total,
            'records_value_total' => $records_value_total,
            'triage_pending_total' => $triage_pending_total,
            'user_value_total' => $user_value_total,
            'employee_counts' => [
                'doctors' => $doctors,
                'nurses' => $nurses,
                'attendants' => $attendants,
            ]
        ];

        return response()->json($values, 200);
    }
}