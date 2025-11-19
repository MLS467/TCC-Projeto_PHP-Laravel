<?php

use App\Models\Bed;

describe('testing bed functions', function () {

    it('checking if the patient critical get a bed correctly', function () {

        // criar  user e um administrador
        $user_admin = createUser();
        $ADMIN = createAdm($user_admin->id);

        // criar um user e um nurse 
        $user_nurse = createUser();
        $NURSE = createNurse($user_nurse->id, $ADMIN->id);

        // fazer login com nurse
        auth()->loginUsingId(2);
        $token = auth()->user()->createToken('token-valid')->plainTextToken;

        $user_patient = createUser();

        Bed::factory(10)->create();

        // inserir o paciente na rota de paciente
        $result = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('api/patient', [
            "user_id" => $user_patient->id,
            "allergy" => "Alergia a penicilina.",
            "sugery_history" => "Cirurgia de apendicite em 2015.",
            "blood_type" => "A+",
            "blood_pressure" => 120,
            "heart_rate" => 78,
            "respiratory_rate" => 18,
            "oxygen_saturation" => 98,
            "temperature" => 36.8,
            "chief_complaint" => "Dor no peito e falta de ar leve desde ontem.",
            "responsible_name" => "Carlos Pereira",
            "emergency_phone" => "11987654321",
            "flag_triage" => 1,
            "patient_condition" => "critical"
        ]);

        // testar se ele recebeu uma bed corretamente
        expect($result->status())->toBe(201);

        expect($result->content())->toBeJson();

        expect($result->content())->toBeGreaterThan(1);

        $result_formatted = json_decode($result->content(), true);

        expect($result_formatted['message'])->toBe("Paciente criado com sucesso");

        // testa se o usuario está relacionado com o leito
        expect(
            Bed::where('user_id', $user_patient->id)
                ->where('status_bed', '=', true)
                ->exists()
        )->toBeTrue();
    });

    it('checking if the patient with mild condition does not get a bed automatically', function () {

        // criar user e um administrador
        $user_admin = createUser();
        $ADMIN = createAdm($user_admin->id);

        // criar um user e um nurse 
        $user_nurse = createUser();
        $NURSE = createNurse($user_nurse->id, $ADMIN->id);

        // fazer login com nurse
        auth()->loginUsingId($user_nurse->id);
        $token = auth()->user()->createToken('token-valid')->plainTextToken;

        $user_patient = createUser();

        Bed::factory(10)->create();

        // inserir o paciente na rota de paciente com condição mild
        $result = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('api/patient', [
            "user_id" => $user_patient->id,
            "allergy" => "Sem alergias conhecidas.",
            "sugery_history" => "Nenhuma cirurgia anterior.",
            "blood_type" => "O+",
            "blood_pressure" => 110,
            "heart_rate" => 72,
            "respiratory_rate" => 16,
            "oxygen_saturation" => 99,
            "temperature" => 36.5,
            "chief_complaint" => "Dor de cabeça leve e fadiga.",
            "responsible_name" => "Ana Silva",
            "emergency_phone" => "11912345678",
            "flag_triage" => 1,
            "patient_condition" => "mild"
        ]);

        // testar se a criação foi bem-sucedida
        expect($result->status())->toBe(201);

        expect($result->content())->toBeJson();

        $result_formatted = json_decode($result->content(), true);

        expect($result_formatted['message'])->toBe("Paciente criado com sucesso");

        // testa se o paciente NÃO foi atribuído automaticamente a um leito
        expect(
            Bed::where('user_id', $user_patient->id)->exists()
        )->toBeFalse();

        // verifica se todos os leitos continuam disponíveis
        expect(
            Bed::whereNull('user_id')->count()
        )->toBe(10);
    });
});