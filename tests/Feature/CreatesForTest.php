<?php

use App\Models\MedicalRecord;
use App\Models\PatientModel;
use App\Models\Adm;
use App\Models\Attendant;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\User;
use Carbon\Carbon;

function createPatient($user_id)
{

    $blood_type = \Faker\Factory::create()->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
    return PatientModel::create([
        "user_id" => $user_id,
        "allergy" => "Alergia a penicilina.",
        "sugery_history" => "Cirurgia de apendicite em 2015.",
        "blood_type" => "A+",
        "blood_pressure" => 120,
        "heart_rate" => 78,
        "respiratory_rate" => 18,
        "oxygen_saturation" => 98,
        "temperature" => 36.8,
        "chief_complaint" => "Dor no peito e falta de ar leve desde ontem.",
        "responsible_name" => "Carlos Pereira",
        "emergency_phone" => "11987654321",
        "flag_triage" => 1,
        "patient_condition" => "serious",
        'responsible_specialist' => 'cardiologista'
    ]);
}

function createUser()
{
    return User::create([
        'name' => \Faker\Factory::create()->name(),
        'email' => \Faker\Factory::create()->unique()->safeEmail(),
        'email_verified_at' => now(),
        'password' => bcrypt('password'), // Senha padrão
        'phone' => \Faker\Factory::create()->phoneNumber(),
        'cpf' => \Faker\Factory::create()->unique()->numerify('###.###.###-##'),
        'sex' => \Faker\Factory::create()->randomElement(['male', 'female', 'other']),
        'birth' => \Faker\Factory::create()->date(),
        'photo' => \Faker\Factory::create()->imageUrl(),
        'place_of_birth' => \Faker\Factory::create()->city(),
        'city' => \Faker\Factory::create()->city(),
        'neighborhood' => \Faker\Factory::create()->word(),
        'street' => \Faker\Factory::create()->streetName(),
        'block' => \Faker\Factory::create()->buildingNumber(),
        'apartment' => \Faker\Factory::create()->word(),
        'role' => \Faker\Factory::create()->randomElement(['admin', 'patient', 'attendant', 'doctor', 'nurse']),
        'age' => \Faker\Factory::create()->numberBetween(18, 99),
    ]);
}

function createAdm($user_id)
{
    return  Adm::create([
        'user_id' => $user_id,
        'active' => true,
    ]);
}

function createAttendant($user_id, $adm_id)
{
    return Attendant::create(
        [
            'user_id' => $user_id,
            'id_administrator_fk' => $adm_id,
            'active' => \Faker\Factory::create()->boolean()
        ]
    );
}

function createNurse($user_id, $adm_id)
{
    return Nurse::create(
        [
            'user_id' => $user_id,
            'id_administrator_fk' => $adm_id,
            'active' => \Faker\Factory::create()->boolean(),
            'coren' => \Faker\Factory::create()->bothify('########'),
            'specialty' => \Faker\Factory::create()->word,
        ]
    );
}

function createDoctor($user_id, $adm_id)
{

    return Doctor::create([
        'user_id' => $user_id,
        'id_administrator_fk' => $adm_id,
        'crm' => strtoupper(\Faker\Factory::create()->bothify('CRM####')),
        'specialty' => 'Cardiologista',
        'active' =>  \Faker\Factory::create()->boolean(80)
    ]);
}


function createPatientRecord($cpf)
{
    MedicalRecord::create([
        'id' => bcrypt(Carbon::now()),
        'full_name' => 'John Doe',
        'cpf' => $cpf,
        'email' => 'teste@teste123.com',
        'gender' => 'M',
        'birth_date' => '1990-01-01',
        'phone' => '11999999999',
        'city' => 'São Paulo',
        'neighborhood' => 'Centro',
        'street' => 'Rua A',
        'block' => '10',
        'apartment' => '101',
        'blood_type' => 'A+',
        'blood_pressure' => '120/80',
        'heart_rate' => '72',
        'respiratory_rate' => '16',
        'oxygen_saturation' => '98',
        'temperature' => '36.5',
        'chief_complaint' => 'Dor de cabeça persistente',
        'patient_condition' => 'Estável',
        'bleeding' => 'Não',
        'difficulty_breathing' => 'Não',
        'edema' => 'Não',
        'nausea' => 'Sim',
        'vomiting' => 'Não',
        'allergy' => 'Nenhuma alergia conhecida',
        'surgery_history' => 'Apendicectomia em 2015',
        'reason_for_consultation' => 'Dor de cabeça há 3 dias',
        'symptoms' => 'Cefaleia, fotofobia leve',
        'consultation_datetime' => '2024-10-04 14:30:00',
        'prescribed_medication' => 'Paracetamol 500mg - 1 comprimido a cada 8h',
        'medical_recommendations' => 'Repouso, hidratação adequada',
        'doctor_observations' => 'Paciente consciente e orientado',
        'performed_procedures' => 'Exame físico geral, aferição de sinais vitais',
        'diagnosis' => 'Cefaleia tensional',
        'additional_notes' => 'Retorno em 7 dias se persistir sintomas',
    ]);
};