<?php

use App\Models\PatientCNS;
use Illuminate\Support\Facades\Auth;

// SearchForPatientByCNSTest

it('test', function () {

    $user_adm = createUser();
    $adm = createAdm($user_adm->id);

    $user_doctor = createUser();
    $doctor = createDoctor($user_doctor->id, $adm->id);

    Auth::loginUsingId($user_doctor->id);

    PatientCNS::factory(10)->create();

    $rand_number = rand(1, 10);

    $cns = PatientCNS::find($rand_number);

    $token = Auth::user()->createToken($user_doctor->name)->plainTextToken;

    $result = $this->withHeaders([
        'Authorization' => "Bearer {$token}"
    ])->postJson('api/sus/pacient', [
        'cns' => $cns->cns
    ]);

    $result_array = json_decode($result->content(), true);

    expect($result->status())->toBe(200);
    expect($result->content())->toBeJson();


    expect($result_array)->toHaveKeys([
        'resourceType',
        'id',
        'identifier',
        'name',
        'gender',
        'birthDate',
        'address',
        'telecom'
    ]);

    expect($result_array['identifier'][0])->toHaveKey('value');
    expect($result_array['identifier'][0]['value'])->toBe($cns->cns);
});