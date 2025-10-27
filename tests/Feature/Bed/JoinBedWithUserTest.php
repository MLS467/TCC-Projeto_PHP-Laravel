<?php

use App\Models\Bed;
use Illuminate\Support\Facades\Auth;

describe('check if method of joing user with bed is correct', function () {


    it('check if user is relationship with bed', function () {

        $values_for_test = loginForTests();

        // fazer a requisição
        $result = $this->withHeaders([
            "Autorization" => "Bearer " . $values_for_test['token']
        ])->postJson('api/bed-with-patient', ['user_id' => $values_for_test['user_patient']->id]);


        // verificar se teve o join
        expect($result->status())->toBe(200);
        expect($result->content())->toBeJson();

        $result_array = json_decode($result->content(), true);

        expect($result_array)->toHaveKey('bed');

        expect(
            Bed::where('user_id', $values_for_test['user_patient']->id)->exists()
        )->toBeTrue();
    });


    it('check with user not found', function () {

        $values_for_test = loginForTests();

        $result = $this->withHeaders([
            "Autorization" => "Bearer " . $values_for_test['token']
        ])->postJson('api/bed-with-patient', ['user_id' => $values_for_test['user_patient']->id + 10]);

        expect($result->status())->toBe(404);

        expect($result->content())->toContain('{"message":"Usu\u00e1rio n\u00e3o encontrado."}');
    });


    it('check if id of user is empty', function () {

        $values_for_test = loginForTests();

        $result = $this->withHeaders([
            "Autorization" => "Bearer " . $values_for_test['token']
        ])->postJson('api/bed-with-patient', ['user_id' => '']);

        expect($result->status())->toBe(404);

        expect($result->content())->toContain('{"message":"Usu\u00e1rio n\u00e3o encontrado."}');
    });


    it('test if user already have a bed', function () {
        $values_for_test = loginForTests();

        // fazer a requisição
        $this->withHeaders([
            "Autorization" => "Bearer " . $values_for_test['token']
        ])->postJson('api/bed-with-patient', ['user_id' => $values_for_test['user_patient']->id]);

        $result = $this->withHeaders([
            "Autorization" => "Bearer " . $values_for_test['token']
        ])->postJson('api/bed-with-patient', ['user_id' => $values_for_test['user_patient']->id]);

        expect($result->status())->toBe(401);

        expect($result->content())->toContain('j\u00e1 est\u00e1 no leito');
    });
});

function loginForTests()
{
    // ter um admin
    $user_admin = createUser(); //1
    $admin = createAdm($user_admin->id);

    // ter um user 
    $user_doctor = createUser(); //2

    //ter um medico
    createDoctor($user_doctor->id, $admin->id);

    // ter uma bed
    Bed::factory()->count(1)->create();

    // criar user paciente
    $user_patient = createUser(); //3

    // fazer login
    Auth::loginUsingId(2);
    $user_authenticate = Auth::user();
    // pegar token
    $token = $user_authenticate->createToken(
        $user_authenticate->name,
        ["*"],
        now()->addHour()
    )->plainTextToken;

    return [
        'user_admin' => $user_admin,
        'admin' => $admin,
        'user_doctor' => $user_doctor,
        'user_patient' => $user_patient,
        'token' => $token
    ];
}