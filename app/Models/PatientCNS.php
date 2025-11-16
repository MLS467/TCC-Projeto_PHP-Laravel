<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientCNS extends Model
{
    use HasFactory;
    protected $table = 'patients_cns';

    protected $fillable = [
        'cns',
        'cpf',
        'nome',
        'genero',
        'data_nascimento',
        'endereco',
        'cidade',
        'estado',
        'cep',
        'telefone'
    ];
}