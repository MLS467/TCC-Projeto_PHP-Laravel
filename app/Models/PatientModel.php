<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientModel extends Model
{
    use HasFactory;
    protected $table = 'patients';

    protected $fillable = [
        'id',
        'user_id',
        'id_attendant',
        'allegy',
        'sugery_history',
        'emergency_contact',
        'blood_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function attendant()
    {
        return $this->belongsTo(Attendant::class);
    }
}