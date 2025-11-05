<?php

use App\Http\Controllers\Api\Attendant\Attendant;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

//----------------------
// UploadPhotoTest
//----------------------

describe("check flow of upload photo is correct and photo url is stored in database", function () {


    it('check if upload of photo is correct', function () {

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = LoginAsAttendantAndGetToken($this, $file);


        expect($response->status())->toBe(201);
        expect($response->content())->toBeJson();

        $user_data = User::where('id', 3)->get()->toArray();


        expect($user_data[0]['name'])->toBe('Lucas Almeida');
        expect($user_data[0]['photo'])->not->toBeNull();

        expect($user_data[0]['photo'])->toContain('https://res.cloudinary.com/dyyiewmgy');
    });

    it('check if upload of photo is correct with value empty', function () {

        $file = "";

        $response = LoginAsAttendantAndGetToken($this, $file);

        expect($response->status())->toBe(201);
        expect($response->content())->toBeJson();

        $user_data = User::where('id', 3)->get()->toArray();

        expect($user_data[0]['name'])->toBe('Lucas Almeida');

        expect($user_data[0]['photo'])->toContain("https://res.cloudinary.com/dyyiewmgy/image/upload/");
    });

    it('check if upload of photo is correct with value wrong', function () {

        $file = "fosdnofdsofoisdafniosdofosa";

        $response = LoginAsAttendantAndGetToken($this, $file);

        expect($response->status())->toBe(422);

        expect($response->content())->toBeJson();

        expect($response->content())->toContain("A foto deve ser uma imagem.");
    });

    it('check if upload of photo is correct with value great then 4096 Kb', function () {

        // Cria um arquivo "falso" com tamanho de 1024 * 1024 KB = 1 GB
        $file = UploadedFile::fake()->create('huge_image.jpg', 1024 * 1024);;

        $response = LoginAsAttendantAndGetToken($this, $file);

        expect($response->status())->toBe(422);

        expect($response->content())->toBeJson();

        expect($response->content())->toContain("A foto n\u00e3o pode ter mais de 4096 KB.");
    });
});

function LoginAsAttendantAndGetToken($test, $file)
{
    $user_admin = createUser(); //1
    $adm = createAdm($user_admin->id);


    $user_att = createUser(); //2
    $att = createAttendant($user_att->id, $adm->id);

    Auth::loginUsingId($user_att->id);
    $token = Auth::user()->createToken($user_att->name)->plainTextToken;

    return $response = $test->withHeaders([
        "Authorization" => "Bearer $token",
    ])->postJson('/api/attendant', [
        'name' => 'Lucas Almeida',
        'email' => 'lucas.almeida@example.com',
        'email_verified_at' => now(),
        'password' => bcrypt('password'), // Senha padrão
        'phone' => '53984072826',
        'cpf' => '12345678901',
        'sex' => Faker\Factory::create()->randomElement(['masculino', 'feminino']),
        'birth' => '1998-07-14',
        'photo' => $file, // UploadedFile::fake()->image('avatar.jpg')
        'place_of_birth' => 'Pelotas',
        'city' => 'Pelotas',
        'neighborhood' => 'Centro',
        'street' => 'Rua Quinze de Novembro',
        'block' => '102',
        'apartment' => 'Apto 302',
        'role' => 'attendant',
        'age' => 27,
        'active' => true,
        'id_administrator_fk' => $user_admin->id,
    ]);
}