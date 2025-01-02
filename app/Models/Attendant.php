<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendant extends Model
{
    /** @use HasFactory<\Database\Factories\AttendantFactory> */
    use HasFactory;

    public function patient()
    {
        return $this->hasMany(PatientModel::class);
    }
}