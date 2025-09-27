<?php

use App\Models\Adm;
use Illuminate\Support\Facades\DB;

it('testing if user can do logout in system', function () {
    $user = createUser();

    $adm = createAdm($user->id);

    $user_id = $user->id;

    expect(
        Adm::where('user_id', $adm->user->id)->exists()
    )->toBeTrue();

    $result =  $this->postJson('api/login', [
        'email' => $adm->user->email,
        'password' => 'password',
    ]);

    expect(
        DB::table('personal_access_tokens')
            ->where('tokenable_id', $user_id)
            ->where('tokenable_type', 'App\\Models\\User')
            ->exists()
    )->toBeTrue();

    expect($result->status())->toBe(200);
    expect($result->content())->toBeJson();
    expect($result->content())->toBeGreaterThan(1);

    $result_array = json_decode($result->content(), true);

    $token = $result_array['token'];
    $auth_user = $result_array['user'];

    $result_get =  $this->withHeaders([
        'Authorization' => 'Bearer ' . $token
    ])->get('api/logout/' . $user_id);

    expect($result_get->status())->toBe(200);

    $result_get_array = json_decode($result_get->content(), true);

    expect($result_get_array['message'])->toBe('Logout realizado com sucesso');

    expect(
        DB::table('personal_access_tokens')
            ->where('tokenable_id', $user_id)
            ->where('tokenable_type', 'App\\Models\\User')
            ->exists()
    )->toBeFalse();
});