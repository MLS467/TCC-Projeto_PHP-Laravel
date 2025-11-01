<?php

use App\Models\Attendant;
use App\Models\User;

describe('Testing crud of Model Attendant', function () {

    it('testing if attendant was inserted, updated, readed and deleted', function () {

        // ----------------
        // CREATE 
        // ----------------

        // cria o usuário
        $user_adm = createUser();

        // cria o administrador
        $adm = createAdm($user_adm->id);

        // faz login com admim para inserir o attendant
        $values_login =  $this->postJson(
            'api/login',
            [
                'email' => $adm->user->email,
                'password' => 'password'
            ]
        );


        // faz a inserção do attendant
        $result_post = $this->withHeaders([
            'Authorization' => "Bearer {$values_login->json('token')}"
        ])->postJson('api/attendant', [
            "id_administrator_fk" => $adm->id,
            "active" => true,
            "name" => "Mariana Costa",
            "email" => "mariana.costa@example.com",
            "email_verified_at" => "2025-10-19T17:00:00Z",
            "password" => "password",
            "phone" => "98855662233",
            "cpf" => "12345678901",
            "sex" => "feminino",
            "birth" => "2000-01-01 01:00:00",
            // "photo" => "www.teste.com/photo.jpg",
            "place_of_birth" => "Rio de Janeiro",
            "city" => "Niterói",
            "neighborhood" => "Icaraí",
            "street" => "Rua das Palmeiras",
            "block" => "25",
            "apartment" => "302",
            "role" => "attendant",
            "age" => 25
        ]);

        // testa se a resposta ta correta
        expect($result_post->status())->toBe(201);
        expect($result_post->content())->toBeGreaterThanOrEqual(1);
        expect($result_post->content())->toBeJson();
        expect(json_decode($result_post->content(), true)['message'])->toBe("Employee created successfully");

        // testando se o attendant inserido corresponde ao user criado juntamente
        expect(
            Attendant::where('id', 1)
                ->where('user_id', 2)->exists()
        )->toBeTrue();

        // ---------------------
        // UPDATE
        // ---------------------

        // faz update do attendant
        $result_put = $this->withHeaders([
            'Authorization' => "Bearer {$values_login->json('token')}"
        ])->putJson(
            "api/attendant/1",
            [
                'id_administrator_fk' => $adm->id,
                'name' => 'batata',
                'place_of_birth' => 'Dunas'
            ]
        );

        // testa o retorno
        expect($result_put->status())->toBe(200);

        // testa se o valor foi modificado
        expect(User::where('name', '=', 'batata')->exists())->toBeTrue();

        // ---------------------
        // READ
        // ---------------------

        // tesando se a rota retorna os dados corretos
        $result_get = $this->withHeaders([
            'Authorization' => "Bearer {$values_login->json('token')}"
        ])->getJson("api/attendant/1");

        // testando o retorno
        expect($result_get->status())->toBe(200);
        expect($result_get->content())->toBeGreaterThan(1);
        expect($result_get->content())->toBeJson();

        // testando o valor do retorno dentro de data
        $data = json_decode($result_get->content(), true)['data'];

        expect($data)->toBeArray();

        expect($data)->toHaveKeys([
            'id_administrator_fk',
            'user_id',
            'active',
            "user"
        ]);

        expect($data["user"])->toBeArray();

        expect($data["user"])->toHaveKeys([
            'name',
            'email',
            'cpf',
            "place_of_birth"
        ]);


        //----------------
        // DELETE
        //----------------

        // testando a rota de delete
        $result_delete = $this->withHeaders([
            'Authorization' => "Bearer {$values_login->json('token')}"
        ])->delete("api/attendant/1");

        // tentando buscar o dado no banco
        expect(User::where('name', '=', 'batata')->exists())->toBeFalse();

        // testando o status da na rota
        $result_deleted = $this->withHeaders([
            'Authorization' => "Bearer {$values_login->json('token')}"
        ])->getJson("api/attendant/1");

        expect($result_deleted->status())->toBe(404);
    });
});