<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Adm;
use App\Models\Attendant;
use App\Models\Bed;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Nurse;
use App\Models\PatientModel;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {

        try {
            //-----------------------
            // Employee
            //-----------------------
            try {

                $doctors = Doctor::count('*');
                $nurses = Nurse::count('*');
                $attendants = Attendant::count('*');
                $adms = Adm::count('*');
            } catch (\Exception $e) {
                $doctors = 0;
                $nurses = 0;
                $attendants = 0;
                $adms = 0;
            }

            //------------------------
            // Values
            //------------------------
            try {

                $consultation_completed_total = Consultation::count('*') ?? 0; // total de consultas concluídas
                $user_value_total = User::count() ?? 0; // total de usuarios 
                $records_value_total = MedicalRecord::count('id') ?? 0;
                $triage_pending_total = PatientModel::where('flag_triage', '=', 0)->count() ?? 0; // total de triagens pendentes
                $consultation_pending_total = PatientModel::where('flag_triage', 1)
                    ->where('flag_consultation', 0)
                    ->count() ?? 0; // total de consultas pendentes 

                $beds = Bed::where('status_bed', true)
                    ->whereNot('user_id', null)
                    ->count('*') ?? 0;
            } catch (\Exception $e) {
                $consultation_completed_total = 0;
                $user_value_total = 0;
                $records_value_total = 0;
                $triage_pending_total = 0;
                $consultation_pending_total = 0;
                $beds = 0;
            }


            //------------------------
            // data all users
            //------------------------

            try {
                $all_employee = [
                    ...Doctor::with('user')->get()->toArray(),
                    ...Nurse::with('user')->get()->toArray(),
                    ...Attendant::with('user')->get()->toArray(),
                    ...Adm::with('user')->get()->toArray(),
                ];
            } catch (\Exception $e) {
                $all_employee = [];
            }

            //------------------------
            // Rates
            //------------------------

            try {
                $precision = 3;
                $rate_begs_occupied = round(($beds / Bed::count('*')) * 100, $precision);
                $rate_consultation_completed = round(($consultation_completed_total / Consultation::count('*')) * 100, $precision);
                $rate_employees = round(($doctors + $nurses + $attendants + $adms) / User::count('*') * 100, $precision);
                $rate_records = round(($records_value_total / PatientModel::count('*')) * 100, $precision);
            } catch (\DivisionByZeroError $e) {
                $rate_begs_occupied = 0;
                $rate_consultation_completed = 0;
                $rate_employees = 0;
                $rate_records = 0;
            }

            $values = [
                'data' => [
                    'consultation_pending_total' => $consultation_pending_total,
                    'records_value_total' => $records_value_total,
                    'triage_pending_total' => $triage_pending_total,
                    'user_value_total' => $user_value_total,
                    'beds_occupied_total' => $beds,
                    'consultation_completed_total' => $consultation_completed_total,
                    'rate' => [
                        'beds_occupied' => $rate_begs_occupied,
                        'consultation_completed' => $rate_consultation_completed,
                        'employees' => $rate_employees,
                        'records' => $rate_records,
                    ],
                    'employee_counts' => [
                        'doctors' => $doctors,
                        'nurses' => $nurses,
                        'attendants' => $attendants,
                    ],
                    'all_employee' => $all_employee,
                ],
            ];

            return response()->json($values, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching dashboard data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}