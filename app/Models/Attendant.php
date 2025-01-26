<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Attendant extends Model
{
    /** @use HasFactory<\Database\Factories\AttendantFactory> */
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'user_id',
        'id_administrator_fk',
        'active'
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