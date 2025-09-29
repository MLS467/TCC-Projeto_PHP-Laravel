<?php

use App\Models\Adm;
use App\Models\Attendant;
use App\Models\Doctor;
use App\Models\Nurse;



describe('testing features of Auth file', function () {

    it('check if login for admin return success', function () {
        $user = createUser();

        $adm = createAdm($user->id);

        expect(
            Adm::where('user_id', $adm->user->id)->exists()
        )->toBeTrue();

        $result =  $this->postJson('api/login', [
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
            Attendant::where('user_id', $attendant->user->id)->exists()
        )->toBeTrue();


        $result =  $this->postJson('api/login', [
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
            Doctor::where('user_id', $doctor->user->id)->exists()
        )->toBeTrue();


        $result = $this->postJson('api/login', [
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
            Nurse::where('user_id', $Nurse->user->id)->exists()
        )->toBeTrue();


        $result =  $this->postJson('api/login', [
            'email' => $Nurse->user->email,
            'password' => 'password',
        ]);


        expect($result->content())->toBeGreaterThan(1);
        expect($result->content())->toBeJson();

        expect($result->status())->toBe(200);

        $response_json = json_decode($result->content(), true);
        expect($response_json)->toHaveKeys(['user', 'token']);
    });


    it('testing with credentials wrongs', function () {

        $user = createUser();

        $adm = createAdm($user->id);

        expect(
            Adm::where('user_id', $adm->user->id)->exists()
        )->toBeTrue();

        $result =  $this->postJson('api/login', [
            'email' => $adm->user->email,
            'password' => 'password1546',
        ]);

        expect($result->status())->not()->toBe(200);
    });


    it('testing with credentials empties', function () {

        $result =  $this->postJson('api/login', [
            'email' => '',
            'password' => '',
        ]);

        expect($result->status())->not()->toBe(302); // não passa na validação
    });
});