<?php

use App\Models\Adm;
use App\Models\Attendant;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\User;

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

describe('testing features of Auth file if return success', function () {

    it('check if login for admin return success', function () {
        $user = createUser();

        $adm = createAdm($user->id);

        expect(
            Adm::where('user_id', $adm->user->id)->exists()
        )->toBeTrue();

        $result =  $this->post('api/login', [
            'email' => $adm->user->email,
            'password' => 'password',
        ]);

        expect($result->content())->toBeGreaterThan(1);
        expect($result->content())->toBeJson();

        expect($result->status())->toBe(200);

        $response_json = json_decode($result->content(), true);
        expect($response_json)->toHaveKeys(['user', 'token']);
    }); //->skip();

    it('check if login for attendant return success', function () {
        $user = createUser();

        $adm = createAdm($user->id);

        $attendant = createAttendant($user->id, $adm->id);


        expect(
            Adm::where('user_id', $attendant->user->id)->exists()
        )->toBeTrue();


        $result =  $this->post('api/login', [
            'email' => $attendant->user->email,
            'password' => 'password',
        ]);


        expect($result->content())->toBeGreaterThan(1);
        expect($result->content())->toBeJson();

        expect($result->status())->toBe(200);

        $response_json = json_decode($result->content(), true);
        expect($response_json)->toHaveKeys(['user', 'token']);
    }); //->skip();

    it('check if login for Doctor return success', function () {
        $user = createUser();

        $adm = createAdm($user->id);

        $doctor = createDoctor($user->id, $adm->id);


        expect(
            Adm::where('user_id', $doctor->user->id)->exists()
        )->toBeTrue();


        $result = $this->post('api/login', [
            'email' => $doctor->user->email,
            'password' => 'password',
        ]);


        expect($result->content())->toBeGreaterThan(1);
        expect($result->content())->toBeJson();

        expect($result->status())->toBe(200);

        $response_json = json_decode($result->content(), true);
        expect($response_json)->toHaveKeys(['user', 'token']);
    }); //->skip();

    it('check if login for Nurse return success', function () {
        $user = createUser();

        $adm = createAdm($user->id);

        $Nurse = createNurse($user->id, $adm->id);


        expect(
            Adm::where('user_id', $Nurse->user->id)->exists()
        )->toBeTrue();


        $result =  $this->post('api/login', [
            'email' => $Nurse->user->email,
            'password' => 'password',
        ]);


        expect($result->content())->toBeGreaterThan(1);
        expect($result->content())->toBeJson();

        expect($result->status())->toBe(200);

        $response_json = json_decode($result->content(), true);
        expect($response_json)->toHaveKeys(['user', 'token']);
    });
});