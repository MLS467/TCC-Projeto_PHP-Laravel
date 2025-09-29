<?php

describe('testing return and structure of seach user by CPF', function () {

    it('testing return using CPF of user', function () {

        $adm_user = createUser();
        $admin = createAdm($adm_user->id);

        $attendant_user = createUser();
        $attendant = createAttendant($attendant_user->id, $admin->id);

        $patient_user = createUser();
        $patient = createPatient($patient_user->id);

        auth()->loginUsingId($attendant->user->id);

        $token = auth()->user()->createToken('token')->plainTextToken;

        $result = $this->withHeaders([
            'Authorization' => "Bearer " . $token
        ])->get('api/user/cpf/' . $patient_user->cpf);

        expect($result->content())->toBeJson();
        expect($result->status())->toBe(200);
        expect($result->content())->toBeGreaterThan(1);

        $data = json_decode($result->content(), true);

        expect($data['message'])->toBe("Patient found");

        expect($data)->toBeArray();

        expect($data)->toHaveKeys([
            'status',
            'message',
            'data',
        ]);

        expect($data['data'])->toBeArray();

        expect($data['data'][0])->toHaveKeys([
            'name',
            'role',
            'birth',
            'place_of_birth',
            'cpf'
        ]);
    });


    it('should return 404 when CPF not found', function () {
        $attendant_user = createUser();
        auth()->loginUsingId($attendant_user->id);
        $token = auth()->user()->createToken('token')->plainTextToken;

        $result = $this->withHeaders([
            'Authorization' => "Bearer " . $token
        ])->get('api/user/cpf/99999999999');

        expect($result->status())->toBe(404);
    });


    it('should require authentication', function () {

        $patient_user = createUser();
        createPatient($patient_user->id);

        $result = $this->get('api/user/cpf/' . $patient_user->cpf);

        expect($result->status())->toBe(401);
    });
});