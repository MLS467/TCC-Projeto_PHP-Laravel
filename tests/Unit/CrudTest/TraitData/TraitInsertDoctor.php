<?php

namespace Tests\Unit\CrudTest\TraitData;


trait TraitInsertDoctor
{
    protected string $baseUrl = "http://localhost:8082";

    protected array  $credentials = [
        'email' => "teste@doutora.com",
        'password' => 12345678
    ];

    protected array $doctor = [
        'name' => 'Ichigo Kurosaki',
        'email' => 'ichigo.kurosaki@gmail.com',
        'email_verified_at' => '2025-01-27',
        'password' => 'Strawberry123',
        'phone' => '55598761234',
        'cpf' => '12345678909',
        'sex' => 'masculino',
        'birth' => '1995-07-15',
        'photo' => 'ichigo.jpg',
        'place_of_birth' => 'Karakura Town',
        'city' => 'Karakura',
        'neighborhood' => 'Shinigami District',
        'street' => 'Zangetsu Avenue',
        'block' => 'A',
        "id_administrator_fk" => 11,
        'apartment' => '302',
        'role' => 'Substitute Shinigami',
        'age' => 29,
        'crm' => 'CRM00001',
        'specialty' => 'cardiologista',
        'active' => 'on'
    ];

    protected array $doctorError = [
        'name' => 'Rukia Kuchiki',
        'email' => 'rukia.kuchiki@bleach.com',
        'email_verified_at' => '2025-01-27',
        'password' => 'Senbonzakura123',
        'phone' => '55587654321',
        'cpf' => '11223344556',
        'sex' => 'feminino',
        'birth' => '1987-01-14',
        'photo' => 'rukia.jpg',
        'place_of_birth' => 'Rukongai',
        'city' => 'Soul Society',
        'neighborhood' => '6th District of Rukongai',
        'street' => 'Kuchiki Clan Mansion',
        'block' => 'A',
        'apartment' => '302',
        'role' => 'Soul Reaper',
        'age' => 30,
        'id_administrator_fk' => 7, // ID do administrador que deverá estar presente no banco
        'crm' => 'SOULE001',
        'specialty' => 'Zanpakuto Mastery',
        'active' => 'on' // Verifique se o campo é 'on' ou um valor booleano como true ou 1
    ];

    protected array $doctorException = [
        'name' => 12345, // nome deve ser uma string, mas é um número
        'email' => 9876543210, // email deve ser uma string, mas é um número
        'password' => true, // senha deve ser uma string, mas é um booleano
        'phone' => false, // telefone deve ser uma string, mas é um booleano
        'cpf' => null, // CPF não pode ser null
        'sex' => 10, // Sexo deveria ser uma string, mas é um número
        'birth' => 12345678, // Data de nascimento deve ser uma string, mas é um número
        'place_of_birth' => false, // Lugar de nascimento deve ser uma string, mas é um booleano
        'city' => '', // Cidade vazia
        'neighborhood' => '', // Bairro vazio
        'street' => null, // Rua não pode ser null
        'block' => true, // Bloco deve ser uma string, mas é um booleano
        'apartment' => [], // Apartamento não pode ser um array
        'role' => 'Soul Reaper', // Ok, mas você pode forçar outros campos com problemas
        'age' => 'não é um número', // Idade deve ser numérica
        'id_administrator_fk' => 7, // ID correto
        'crm' => [], // CRM deve ser uma string, mas é um array
        'specialty' => '', // Especialidade vazia
        'active' => 'on', // Ok, mas pode ser um valor booleano
    ];
}