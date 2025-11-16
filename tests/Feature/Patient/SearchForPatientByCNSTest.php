<?php

use App\Models\PatientCNS;
use Illuminate\Support\Facades\Auth;

// SearchForPatientByCNSTest
describe('Search Patient By CNS', function () {

    it('check if Search patient by cns response correctly', function () {

        $values = LoginForCNS();

        $result = $this->withHeaders([
            'Authorization' => "Bearer {$values['token']}"
        ])->postJson('api/sus/pacient', [
            'cns' => $values['cns']
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
        expect($result_array['identifier'][0]['value'])->toBe($values['cns']);
    });


    it('check if Search patient with cns empty', function () {

        $values = LoginForCNS();

        $result = $this->withHeaders([
            'Authorization' => "Bearer {$values['token']}"
        ])->postJson('api/sus/pacient', [
            'cns' => ''
        ]);

        expect($result->status())->toBe(400);
        expect($result->content())->toContain("CNS n\u00e3o informado");
    });


    it('check if Search patient with cns wrong', function () {

        $values = LoginForCNS();

        $result = $this->withHeaders([
            'Authorization' => "Bearer {$values['token']}"
        ])->postJson('api/sus/pacient', [
            'cns' => '111111111111111'
        ]);

        expect($result->status())->toBe(404);
        expect($result->content())->toContain("Paciente n\u00e3o encontrado");
    });
});



function LoginForCNS(): array
{
    $user_adm = createUser();
    $adm = createAdm($user_adm->id);

    $user_doctor = createUser();
    $doctor = createDoctor($user_doctor->id, $adm->id);

    Auth::loginUsingId($user_doctor->id);

    PatientCNS::factory(10)->create();

    $rand_number = rand(1, 10);

    $cns = PatientCNS::find($rand_number);

    $token = Auth::user()->createToken($user_doctor->name)->plainTextToken;

    return [
        'cns' => $cns->cns,
        'token' => $token
    ];
}