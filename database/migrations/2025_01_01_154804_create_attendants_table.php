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
        Schema::create('attendants', function (Blueprint $table) {
            $table->id();
            $table->foreign('id_user_fk')->references('id')->on('users');
            $table->foreign('id_adm_fk')->references('id')->on('adms');
            $table->date('work_start_date')->nullable();
            $table->date('work_end_date')->nullable();
            $table->status('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendants');
    }
};