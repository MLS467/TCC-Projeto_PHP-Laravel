<?php

namespace Tests\Unit\LoginTest;

use Tests\Unit\LoginTest\traitLoginTest\Login;

class LoginTest extends \Tests\TestCase
{
    use Login;

    protected ?int $id;
    protected string $token;


    /**
     * - setUp é um método do PHPUnit que é executado antes de cada teste.
     * - Configura os dados de login para os testes
     */
    protected function setUp(): void
    {
        parent::setUp();
        // Configura os dados de login para os testes
        $response = $this->json('POST', $this->baseUrl . '/api/login', $this->credentials);
        $this->token = $response->json('token');
        $this->id = $response->json('user')['id'];
    }


    /**
     * @test
     * - Testa o login
     * - Testa se o status da resposta é 200
     * - Testa se o token foi gerado
     */
    public function testLogin()
    {
        $response = $this->json('POST', $this->baseUrl . '/api/login', $this->credentials);
        $response->assertStatus(200);
        $this->assertNotNull($this->id, 'ID não foi configurado corretamente.');
    }

    /**
     * @test
     * - testa o login sem passar o email
     * - Testa se o status da resposta é 422
     * - Testa se a mensagem de erro é a esperada
     * - Testa se o erro é o esperado
     * - Testa se o campo email é obrigatório
     */
    public function testErrorLoginEmail()
    {
        $response = $this->json('POST', $this->baseUrl . '/api/login', $this->credentialsErrorEmail);
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => 'O campo email é obrigatório',
        ]);

        $response->assertJsonFragment([
            'errors' => [
                'email' => ['O campo email é obrigatório']
            ]
        ]);
    }

    /**
     * @test
     * - testa o login sem passar a senha
     * - Testa se o status da resposta é 422
     * - Testa se a mensagem de erro é a esperada
     * - Testa se o erro é o esperado
     * - Testa se o campo senha é obrigatório
     */
    public function testErrorLoginPassword()
    {
        $response = $this->json('POST', $this->baseUrl . '/api/login', $this->credentialsErrorPassword);
        $response->assertStatus(422);
        $response->assertJsonFragment([
            "password" => [
                "O campo senha é obrigatório"
            ]
        ]);

        $response->assertJsonFragment([
            "message" => "O campo senha é obrigatório"
        ]);
    }


    /**
     * @test
     * - testa o login com senha incompleta
     * - Testa se o status da resposta é 422
     * - Testa se a mensagem de erro é a esperada
     * - Testa se o erro é o esperado
     * - Testa se o campo senha é obrigatório
     */
    public function testePasswordIncomplete(): void
    {
        $response = $this->json('POST', $this->baseUrl . '/api/login', $this->credentialsErrorPasswordIncomplete);
        $response->assertStatus(422);
        $response->assertJsonFragment([
            "password" => [
                "O campo senha deve ter no mínimo 8 caracteres"
            ]
        ]);
    }

    /**
     * @test
     * - testa o login com email incompleto
     * - Testa se o status da resposta é 422
     * - Testa se a mensagem de erro é a esperada
     * - Testa se o erro é o esperado
     */
    public function testeEmailIncomplete(): void
    {
        $response = $this->json('POST', $this->baseUrl . '/api/login', $this->credentialsErrorEmailIncomplete);
        $response->assertStatus(422);
        $response->assertJsonFragment([
            "email" => [
                "O campo email é obrigatório"
            ]
        ]);
    }

    /**
     * @test
     * - testa o login com email e senha inválidos
     * - Testa se o status da resposta é 401
     * - Testa se a mensagem de erro é a esperada
     * - Testa se o erro é o esperado
     * - Testa se o email ou senha são inválidos
     */
    public function testeCredentialsNotExist(): void
    {
        $response = $this->json('POST', $this->baseUrl . '/api/login', $this->credentialsErrorFildsNotExists);
        $response->assertStatus(401);
        $response->assertJsonFragment([
            "message" => "Senha ou email inválidos"
        ]);
    }

    /**
     * @test
     * - testa o login com email e senha inválidos
     * - Testa se o status da resposta é 422
     * - Testa se a mensagem de erro é a esperada
     * - Testa se o erro é o esperado
     * - Testa se o email ou senha são inválidos
     */
    public function testeCredentialsInvalids(): void
    {
        $response = $this->json('POST', $this->baseUrl . '/api/login', $this->CredentialsInvalids);
        $response->assertStatus(422);
        $response->assertJsonFragment([
            "email" => [
                "O campo email deve ser um email válido"
            ]
        ]);
    }

    /**
     * @test
     * - testa o login com email e senha vazios
     * - Testa se o status da resposta é 422
     * - Testa se a mensagem de erro é a esperada
     * - Testa se o erro é o esperado
     * - Testa se o email ou senha são inválidos
     * - Testa se o campo email é obrigatório
     * - Testa se o campo senha é obrigatório
     * - Testa se o email ou senha são inválidos
     * - Testa se o campo email é obrigatório
     * - Testa se o campo senha é obrigatório
     */
    public function testCredentialsEmptys(): void
    {
        $response = $this->json('POST', $this->baseUrl . '/api/login', ['email' => '', 'password' => '']);
        $response->assertStatus(422);
        $response->assertJsonFragment([
            "email" => [
                "O campo email é obrigatório"
            ]
        ]);

        $response->assertJsonFragment([
            "password" => [
                "O campo senha é obrigatório"
            ]
        ]);
    }


    /**
     * @test
     * - Testa o logout
     * - Testa se o status da resposta é 200
     * - Testa se o token foi removido
     */
    public function testLogout()
    {

        if ($this->id) {
            $response = $this->json('GET', $this->baseUrl . "/api/logout/{$this->id}", [], ['Authorization' => 'Bearer ' . $this->token]);
            $response->assertStatus(200);
        }
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }
}