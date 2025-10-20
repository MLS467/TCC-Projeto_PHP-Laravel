<?php

use Carbon\Carbon;

it('Check if record route store and show', function () {

    $data = [
        'id' => Faker\Factory::create()->numberBetween(10000, 999999),
        'full_name' => 'John Doe',
        'cpf' => '11111111111',
        'email' => 'teste@teste123.com',
        'gender' => 'M',
        'birth_date' => '1990-01-01',
        'phone' => '11999999999',
        'city' => 'São Paulo',
        'neighborhood' => 'Centro',
        'street' => 'Rua A',
        'block' => '10',
        'apartment' => '101',
        'blood_type' => 'A+',
        'blood_pressure' => '120/80',
        'heart_rate' => '72',
        'respiratory_rate' => '16',
        'oxygen_saturation' => '98',
        'temperature' => '36.5',
        'chief_complaint' => 'Dor de cabeça persistente',
        'patient_condition' => 'Estável',
        'bleeding' => 'Não',
        'difficulty_breathing' => 'Não',
        'edema' => 'Não',
        'nausea' => 'Sim',
        'vomiting' => 'Não',
        'allergy' => 'Nenhuma alergia conhecida',
        'surgery_history' => 'Apendicectomia em 2015',
        'reason_for_consultation' => 'Dor de cabeça há 3 dias',
        'symptoms' => 'Cefaleia, fotofobia leve',
        'consultation_datetime' => '2024-10-04 14:30:00',
        'prescribed_medication' => 'Paracetamol 500mg - 1 comprimido a cada 8h',
        'medical_recommendations' => 'Repouso, hidratação adequada',
        'doctor_observations' => 'Paciente consciente e orientado',
        'performed_procedures' => 'Exame físico geral, aferição de sinais vitais',
        'diagnosis' => 'Cefaleia tensional',
        'additional_notes' => 'Retorno em 7 dias se persistir sintomas',
    ];


    $user_adm = createUser();
    $adm = createAdm($user_adm->id);


    $user_doctor = createUser();
    $doctor = createDoctor($user_doctor->id, $adm->id);

    auth()->loginUsingId($user_doctor->id);

    $token = auth()->user()->createToken('test-token')->plainTextToken;


    $result = $this->withHeaders([
        'Authorization' => "Bearer " . $token
    ])->postJson('api/medical-record', $data);


    expect($result->status())->toBe(201);

    $result_data_post = json_decode($result->content(), true);



    $result_get = $this->withHeaders([
        'Authorization' => "Bearer " . $token
    ])->get('api/medical-record/' . $result_data_post['data']['id']);

    expect($result_get->status())->toBe(200);

    expect($result_get->content())->toBeJson();

    $data_json = json_decode($result_get->content(), true);


    expect($data_json['data']['cpf'])->toBe($result_data_post['data']['cpf']);
});