<?php

use App\Models\PatientModel;


describe('Check if crud of patient is ok', function () {

    it('testing crud complete', function () {
        $user_admin = createUser();

        $attendant_user = createUser();

        createAdm($user_admin->id);

        $attendant = createAttendant($attendant_user->id, $user_admin->id);

        $patient_user = createUser();


        auth()->loginUsingId($user_admin->id);

        $token = auth()->user()->createToken('test-token')->plainTextToken;


        $validPatientData = [
            'user_id' => $patient_user->id,
            'heart_rate' => 80,                    // int, não string
            'respiratory_rate' => 16,              // int, não string  
            'oxygen_saturation' => 98,             // <= 100
            'temperature' => 36.5,                 // <= 45
            'emergency_phone' => '11999887766',    // 8-15 dígitos
            'responsible_name' => 'João Silva',
            'blood_type' => 'O+',
            'patient_condition' => 'Severus'
        ];

        $result_post_patient = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('api/patient', $validPatientData);


        expect($result_post_patient->status())->toBe(201);

        expect(PatientModel::where('id', 1)->exists())->toBeTrue();



        // READ ALL

        $request_patient = $this->get('api/patient/1');
        expect($request_patient->content())->toBeJson();

        $patient_data = json_decode($request_patient->content(), true);


        expect($patient_data['data'])->toHaveKeys([
            'patient_condition',
            'oxygen_saturation',
            'difficulty_breathing',
        ]);

        expect($patient_data['data']['user'])->toHaveKeys([
            'name',
            'email',
            'birth'
        ]);



        // READ ONE

        $request_patient = $this->get('api/patient');
        expect($request_patient->content())->toBeJson();

        expect($request_patient->status())->toBe(200);
        $patient_data = json_decode($request_patient->content(), true);


        expect($patient_data['data'][0])->toHaveKeys([
            'patient_condition',
            'oxygen_saturation',
            'difficulty_breathing',
        ]);

        expect($patient_data['data'][0]['user'])->toHaveKeys([
            'name',
            'email',
            'birth'
        ]);


        // UPDATE
        $data = [
            'oxygen_saturation' => 22,
            'difficulty_breathing' => 'on',
            'temperature' => 38
        ];


        $result_put = $this->putJson('api/patient/1', $data);

        expect($result_put->status())->toBe(200);
        expect($result_put->content())->toBeGreaterThan(1);
        expect($result_put->content())->toBeJson();

        $result_put_array = json_decode($result_put->content(), true);


        expect($result_put_array['message'])->toBe("updated successfully");
        expect($result_put_array['data']['oxygen_saturation'])->toBe(22);
        expect($result_put_array)->toBeArray();


        // delete

        $result_delete = $this->deleteJson('api/patient/1');

        expect($result_delete->content())->toBeJson();
        expect($result_delete->content())->toBeGreaterThan(1);
        expect($result_delete->status())->toBe(200);

        $result_delete_array = json_decode($result_delete->content(), true);

        expect($result_delete_array["message"])->toBe("Model deleted successfully");

        expect(PatientModel::where('id', 1)->exists())->toBeFalse();
    });
});