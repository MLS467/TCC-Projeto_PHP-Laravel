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
        'user_id' => $user_id,
        'allergy' => \Faker\Factory::create()->text(100),
        'sugery_history' => \Faker\Factory::create()->text(100),
        'blood_type' => $blood_type,
        'blood_pressure' => \Faker\Factory::create()->randomFloat(2, 60, 200),
        'heart_rate' => \Faker\Factory::create()->randomFloat(2, 60, 200),
        'respiratory_rate' => \Faker\Factory::create()->randomFloat(2, 60, 200),
        'oxygen_saturation' => \Faker\Factory::create()->randomFloat(2, 60, 200),
        'temperature' => \Faker\Factory::create()->randomFloat(2, 60, 200),
        'chief_complaint' => \Faker\Factory::create()->text(100),
        'responsible_name' => \Faker\Factory::create()->name,
        'emergency_phone' => \Faker\Factory::create()->phoneNumber,
        'flag_triage' => 1,
        'responsible_specialist' => 'cardiologista',
        'patient_condition' => \Faker\Factory::create()->randomElement(['critical', 'serious', 'mild', 'moderate']),
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
    $especialidades = [
        'Cardiologista',
        'Pediatra',
        'Ortopedista',
        'Dermatologista',
        'Neurologista'
    ];

    return Doctor::create([
        'user_id' => $user_id,
        'id_administrator_fk' => $adm_id,
        'crm' => strtoupper(\Faker\Factory::create()->bothify('CRM####')),
        'specialty' => $especialidades[0],
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