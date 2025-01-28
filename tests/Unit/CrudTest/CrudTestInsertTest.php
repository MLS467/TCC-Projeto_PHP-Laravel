<?php

namespace Tests\Unit\CrudTest;

use App\Models\User;
use Tests\Unit\CrudTest\TraitData\TraitInsertDoctor;


class CrudTestInsertTest extends \Tests\TestCase
{
    use TraitInsertDoctor;

    /**
     * @test
     * - simula a inserção de um usuário médico
     * - simula a autenticação do usuário
     * - simula a inserção de um médico
     * - simula a exclusão do médico
     * - simula a exclusão do usuário
     */
    public function testInsertUserDoctor()
    {
        $user = $this->json('POST', "{$this->baseUrl}/api/login", $this->credentials);

        $response = $this->json('POST', "{$this->baseUrl}/api/doctor", $this->doctor, [
            'Authorization' => "Bearer {$user['token']}"
        ]);

        $response->assertStatus(201);

        $response = User::where('email', $this->doctor['email'])->first()->delete();

        $this->assertTrue($response);
    }

    /**
     * @test
     * - simula o quando o usuário não está autenticado
     */
    public function testInsertUserDoctorError()
    {
        $response = $this->json('POST', "{$this->baseUrl}/api/doctor", $this->doctorError);

        $response->assertStatus(401);
    }


    /**
     * @test
     * - simula dados não processáveis
     * - simula a inserção de um usuário médico
     * - simula a autenticação do usuário
     * - simula a inserção de dados inconsistentes médico
     */
    public function testInsertUserUnprocessableContent()
    {
        $user = $this->json('POST', "{$this->baseUrl}/api/login", $this->credentials);

        $response = $this->json('POST', "{$this->baseUrl}/api/doctor", $this->doctorException, [
            'Authorization' => "Bearer {$user['token']}"
        ]);

        $response->assertStatus(422);
    }


    /**
     * @test
     * - simula quando o banco de dados não está disponível
     */
    // public function testInsertUserException()
    // {
    //     DB::disconnect();

    //     $this->expectException(\Exception::class);


    //     $user = $this->json('POST', "{$this->baseUrl}/api/login", $this->credentials);

    //     $response = $this->json('POST', "{$this->baseUrl}/api/doctor", $this->doctorException, [
    //         'Authorization' => "Bearer {$user['token']}"
    //     ]);

    //     dump($response->json());
    // }
}