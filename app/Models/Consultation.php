<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    /** @use HasFactory<\Database\Factories\ConsultationFactory> */
    use HasFactory;

    protected $fillable = [
        'reason_for_consultation',
        'symptoms',
        'date_time',
        'prescribed_medication',
        'medical_recommendations',
        'doctor_observations',
        'performed_procedures',
        'diagnosis',
        'additional_notes',
        'patient_id',
        'flag_consultation'
    ];
}