<?php

use App\Models\PatientModel;
use App\Models\Adm;
use App\Models\Attendant;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\User;

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
        'specialty' =>  \Faker\Factory::create()->randomElement($especialidades),
        'active' =>  \Faker\Factory::create()->boolean(80)
    ]);
}