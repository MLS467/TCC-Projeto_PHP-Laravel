<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Adm extends Model
{
    /** @use HasFactory<\Database\Factories\AdmFactory> */
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'user_id',
        'id_administrator_fk',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function doctor()
    {
        return $this->hasMany(Doctor::class);
    }
    public function attendant()
    {
        return $this->hasMany(Attendant::class);
    }
    public function nurse()
    {
        return $this->hasMany(Nurse::class);
    }
}