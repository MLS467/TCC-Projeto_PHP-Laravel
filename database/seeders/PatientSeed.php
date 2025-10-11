<?php

namespace Database\Seeders;

use App\Models\PatientModel as Patient;
use Illuminate\Database\Seeder;

class PatientSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::insert([
            'user_id' => 1,
            'allergy' => \Faker\Factory::create()->text(100),
            'sugery_history' => \Faker\Factory::create()->text(100),
            'blood_type' => 'A+',
            'blood_pressure' => \Faker\Factory::create()->randomFloat(2, 60, 200),
            'heart_rate' => \Faker\Factory::create()->randomFloat(2, 60, 200),
            'respiratory_rate' => \Faker\Factory::create()->randomFloat(2, 60, 200),
            'oxygen_saturation' => \Faker\Factory::create()->randomFloat(2, 60, 200),
            'temperature' => \Faker\Factory::create()->randomFloat(2, 60, 200),
            'chief_complaint' => \Faker\Factory::create()->text(100),
            'responsible_name' => \Faker\Factory::create()->name,
            'emergency_phone' => \Faker\Factory::create()->phoneNumber,
            'flag_triage' => 1,
            'patient_condition' => \Faker\Factory::create()->randomElement(['critical', 'serious', 'mild', 'moderate']),
        ]);
    }
}