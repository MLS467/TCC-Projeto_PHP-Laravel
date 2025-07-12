<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $table = 'medical_records';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'full_name',
        'cpf',
        'email',
        'gender',
        'birth_date',
        'phone',
        'city',
        'neighborhood',
        'street',
        'block',
        'apartment',
        'blood_type',
        'blood_pressure',
        'heart_rate',
        'respiratory_rate',
        'oxygen_saturation',
        'temperature',
        'chief_complaint',
        'patient_condition',
        'bleeding',
        'difficulty_breathing',
        'edema',
        'nausea',
        'vomiting',
        'allergy',
        'surgery_history',
        'reason_for_consultation',
        'symptoms',
        'consultation_datetime',
        'prescribed_medication',
        'medical_recommendations',
        'doctor_observations',
        'performed_procedures',
        'diagnosis',
        'additional_notes',
    ];
}