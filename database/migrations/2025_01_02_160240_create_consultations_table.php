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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->foreignId('patient_id')->constrained('patient')->onDelete('cascade');
            $table->string('reason_for_consultation', 255);
            $table->text('symptoms');
            $table->dateTime('date_time');
            $table->string('prescribed_medication', 255)->nullable();
            $table->text('medical_recommendations')->nullable();
            $table->text('doctor_observations')->nullable();
            $table->text('performed_procedures')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('additional_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};