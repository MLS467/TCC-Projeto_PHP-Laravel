<?php

use App\Models\Bed;
use Illuminate\Support\Facades\Auth;

describe('check if method of separating user from bed is correct', function () {

    it('check if user is successfully separated from bed', function () {

        $values_for_test = loginForTests();

        // Primeiro, vincular o usuário a uma cama
        $bed = Bed::factory()->create([
            'user_id' => $values_for_test['user_patient']->id,
            'status_bed' => true
        ]);

        // fazer a requisição para separar
        $result = $this->withHeaders([
            "Autorization" => "Bearer " . $values_for_test['token']
        ])->postJson('api/bed-separate-patient', ['id' => $bed->id]);

        // verificar se a separação foi bem-sucedida
        expect($result->status())->toBe(200);
        expect($result->content())->toBeJson();

        $result_array = json_decode($result->content(), true);

        expect($result_array)->toHaveKey('message');
        expect($result_array['message'])->toBe('Paciente desvinculado com sucesso!');

        // verificar se o bed foi realmente desvinculado
        $bed_updated = Bed::find($bed->id);
        expect($bed_updated->user_id)->toBeNull();
        expect($bed_updated->status_bed)->toBe(0);
    });

    it('check with bed not found', function () {

        $values_for_test = loginForTests();

        $result = $this->withHeaders([
            "Autorization" => "Bearer " . $values_for_test['token']
        ])->postJson('api/bed-separate-patient', ['id' => 9999]);

        expect($result->status())->toBe(404);

        expect($result->content())->toContain('{"message":"Leito n\u00e3o encontrado"}');
    });

    it('check if id of bed is empty', function () {

        $values_for_test = loginForTests();

        $result = $this->withHeaders([
            "Autorization" => "Bearer " . $values_for_test['token']
        ])->postJson('api/bed-separate-patient', ['id' => '']);

        expect($result->status())->toBe(422);

        // Verifica se retorna erro de validação
        $result_array = json_decode($result->content(), true);
        expect($result_array)->toHaveKey('errors');
    });

    it('check if id parameter is missing', function () {

        $values_for_test = loginForTests();

        $result = $this->withHeaders([
            "Autorization" => "Bearer " . $values_for_test['token']
        ])->postJson('api/bed-separate-patient', []);

        expect($result->status())->toBe(422);

        // Verifica se retorna erro de validação
        $result_array = json_decode($result->content(), true);
        expect($result_array)->toHaveKey('errors');
        expect($result_array['errors'])->toHaveKey('id');
    });

    it('check if id is not an integer', function () {

        $values_for_test = loginForTests();

        $result = $this->withHeaders([
            "Autorization" => "Bearer " . $values_for_test['token']
        ])->postJson('api/bed-separate-patient', ['id' => 'not-an-integer']);

        expect($result->status())->toBe(422);

        // Verifica se retorna erro de validação
        $result_array = json_decode($result->content(), true);
        expect($result_array)->toHaveKey('errors');
        expect($result_array['errors'])->toHaveKey('id');
    });

    it('check separation of bed that already has no patient', function () {

        $values_for_test = loginForTests();

        // Criar uma cama sem paciente
        $bed = Bed::factory()->create([
            'user_id' => null,
            'status_bed' => false
        ]);

        $result = $this->withHeaders([
            "Autorization" => "Bearer " . $values_for_test['token']
        ])->postJson('api/bed-separate-patient', ['id' => $bed->id]);

        // Deve funcionar normalmente mesmo se já estiver separado
        expect($result->status())->toBe(200);
        expect($result->content())->toContain('Paciente desvinculado com sucesso!');

        // verificar se continua desvinculado
        $bed_updated = Bed::find($bed->id);
        expect($bed_updated->user_id)->toBeNull();
        expect($bed_updated->status_bed)->toBe(0);
    });
});