<?php



it('testing if you get all the necessary data', function () {

    $user = createUser(); // criando um usuário
    $admin = createAdm($user->id); // criando um admin com id 1

    auth()->loginUsingId(1); // logando o admin com id 1 diretamente no sistema interno do laravel

    $token = auth()->user()->createToken('API Token')->plainTextToken;

    $response = $this->withHeaders([
        'Autorization' => 'Bearer ' . $token,
    ])->getJson('api/dashboard'); // fazendo a requisição

    expect($response->content())->toBeJson();



    // // testando o retorno
    expect($response->status())->toBe(200);
    expect($response->content())->toBeGreaterThan(1);
    expect($response->content())->toBeJson();

    // // transformando o json em um array associativo
    $response_json = json_decode($response->content(), true);

    expect($response_json)->toBeArray();

    // checando a estrura da resposta
    expect($response_json)->toHaveKeys([
        'data',
    ]);

    expect($response_json['data']['employee_counts'])->toBeArray();

    expect($response_json['data']['employee_counts'])->toHaveKeys([
        'doctors',
        'nurses',
        'attendants'
    ]);
});