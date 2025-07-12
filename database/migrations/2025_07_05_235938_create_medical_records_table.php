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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID from frontend

            // User (basic info)
            $table->string('full_name');
            $table->string('cpf', 14);
            $table->string('email')->nullable();
            $table->string('gender', 20)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('street')->nullable();
            $table->string('block')->nullable();
            $table->string('apartment')->nullable();

            // Triage
            $table->string('blood_type')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->string('heart_rate')->nullable();
            $table->string('respiratory_rate')->nullable();
            $table->string('oxygen_saturation')->nullable();
            $table->float('temperature')->nullable();
            $table->string('chief_complaint')->nullable();
            $table->string('patient_condition')->nullable();
            $table->boolean('bleeding')->nullable();
            $table->boolean('difficulty_breathing')->nullable();
            $table->boolean('edema')->nullable();
            $table->boolean('nausea')->nullable();
            $table->boolean('vomiting')->nullable();
            $table->text('allergy')->nullable();
            $table->text('surgery_history')->nullable();

            // Consultation
            $table->text('reason_for_consultation')->nullable();
            $table->text('symptoms')->nullable();
            $table->timestamp('consultation_datetime')->nullable();
            $table->text('prescribed_medication')->nullable();
            $table->text('medical_recommendations')->nullable();
            $table->text('doctor_observations')->nullable();
            $table->text('performed_procedures')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('additional_notes')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};