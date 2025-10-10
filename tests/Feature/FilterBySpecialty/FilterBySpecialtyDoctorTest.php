<?php

// FilterBySpecialtyDoctorTest
describe('testing if the datas returns correctly', function () {


    it('check if the specialty corresponds to the responsible specialty', function () {
        // adicionar um adm para criar o médico
        $user_adm = createUser(); // id 1
        $adm = createAdm($user_adm->id);

        // criar um médico com especialidade de cardiologista por exemplo
        $user_doctor = createUser(); //id 2
        $doctor = createDoctor($user_doctor->id, $adm->id);

        // criar um paciente com a especilidade do reponsavel igual a cardiologista
        $user_patient = createUser(); // id 3
        $patient = createPatient($user_patient->id);

        // fazer login com esse médico
        auth()->loginUsingId(2);
        $token = auth()->user()->createToken('token-exemplo')->plainTextToken;

        // testar a rota /patientCompleted

        $result = $this->withoutHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('api/patientCompleted');

        expect($result->status())->toBe(200);
        expect($result->content())->toBeJson();

        $result_array = json_decode($result->content(), true);

        expect(count($result_array))->toEqual(1);

        // deve retornar o paciente que foi inserido anteriormente

        expect($result_array[0]['user'])->toHaveKey('name', $user_patient->name);
        expect($result_array[0]['user'])->toHaveKey('email', $user_patient->email);
        expect($result_array[0]['user'])->toHaveKey('cpf', $user_patient->cpf);
    });


    it('check if the specialty dont corresponds to the responsible specialty', function () {
        // adicionar um adm para criar o médico
        $user_adm = createUser(); // id 1
        $adm = createAdm($user_adm->id);

        // criar um médico com especialidade de cardiologista por exemplo
        $user_doctor = createUser(); //id 2
        $doctor = createDoctor($user_doctor->id, $adm->id);
        $doctor->specialty = 'Pediatra';
        $doctor->save();

        // criar um paciente com a especilidade do reponsavel igual a cardiologista
        $user_patient = createUser(); // id 3
        $patient = createPatient($user_patient->id);

        // fazer login com esse médico
        auth()->loginUsingId(2);
        $token = auth()->user()->createToken('token-exemplo')->plainTextToken;

        // testar a rota /patientCompleted
        $result = $this->withoutHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('api/patientCompleted');

        expect($result->status())->toBe(200);
        expect($result->content())->toBeJson();

        $result_array = json_decode($result->content(), true);

        expect(count($result_array))->toEqual(0);
    });
});