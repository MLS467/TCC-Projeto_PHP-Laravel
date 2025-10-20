<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class PatientModel extends Model
{
    use HasFactory;
    protected $table = 'patients';

    protected $fillable = [
        'user_id',
        'heart_rate',
        'respiratory_rate',
        'oxygen_saturation',
        'temperature',
        'chief_complaint',
        'responsible_name',
        'triage_flag',
        'blood_type',
        'difficulty_breathing',
        'vomiting',
        'edema',
        'nausea',
        'bleeding',
        'emergency_phone',
        'sugery_history',
        'allergy',
        'blood_pressure',
        'responsible_name',
        'flag_triage',
        'flag_consultation',
        'patient_condition',
        'responsible_specialist'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function attendant()
    {
        return $this->belongsTo(Attendant::class);
    }

    public function bed()
    {
        return $this->hasOneThrough(Bed::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }
}
