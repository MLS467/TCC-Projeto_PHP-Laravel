<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Nurse extends Model
{
    /** @use HasFactory<\Database\Factories\NurseFactory> */
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'user_id',
        'id_administrator_fk',
        'active',
        'coren',
        'speciality'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adm()
    {
        return $this->belongsTo(Adm::class);
    }
}