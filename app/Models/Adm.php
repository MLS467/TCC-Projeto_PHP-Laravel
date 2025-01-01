<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adm extends Model
{
    /** @use HasFactory<\Database\Factories\AdmFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'work_start_date',
        'work_end_date'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}