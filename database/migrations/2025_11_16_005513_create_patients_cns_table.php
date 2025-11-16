<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients_cns', function (Blueprint $table) {
            $table->id();
            $table->string('cns', 15)->unique();
            $table->string('cpf', 11)->unique();
            $table->string('nome');
            $table->string('genero');
            $table->date('data_nascimento');
            $table->string('endereco');
            $table->string('cidade');
            $table->string('estado', 2);
            $table->string('cep', 9);
            $table->string('telefone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients_cns');
    }
};