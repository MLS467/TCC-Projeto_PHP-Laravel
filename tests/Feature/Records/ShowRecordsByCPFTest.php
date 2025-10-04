<?php

use App\Models\Adm;
use App\Models\MedicalRecord;
use Carbon\Carbon;

beforeEach(function () {
    $this->cpf = '12345678900';
});

it('check if records by cpf return data corrects', function () {


    createPatientRecord($this->cpf);

    $user_adm = createUser();
    $adm = createAdm($user_adm->id);


    $user_doctor = createUser();
    $doctor = createDoctor($user_doctor->id, $adm->id);

    auth()->loginUsingId($user_doctor->id);

    $token = auth()->user()->createToken('test-token')->plainTextToken;


    $result = $this->withHeaders([
        'Authorization' => "Bearer " . $token
    ])->getJson('api/medical-record/search/' . $this->cpf);

    expect($result->status())->toBe(200);

    expect($result->json())->toHaveKey('data');

    $json_keys = json_decode($result->content(), true);


    expect($json_keys['data'][0])->toHaveKeys([
        'id',
        'full_name',
        'created_at'
    ]);
});