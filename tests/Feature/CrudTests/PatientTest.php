<?php

it('example', function () {
    $user_admin =  createUser();

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
})->todo("Tenho que continuar esse teste");