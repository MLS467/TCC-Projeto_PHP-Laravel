<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

describe('check if is possible reset password', function () {

    it('check if reset password', function () {
        $user = createUser();

        $result = $this->postJson('api/reset-password-email', [
            'email' => $user->email
        ]);

        expect($result->status())->toBe(200);
        expect($result->content())->toBeJson();


        $content = json_decode($result->content(), true);

        expect(count($content))->toEqual(3);

        expect($content['success'])->toBeTrue();

        expect($content)->toHaveKeys([
            'success',
            'email',
            'reset_url'
        ]);

        expect($content['reset_url'])->toContain('token');
        expect($content['reset_url'])->toContain('email');

        preg_match('/token=([^&]+)/', $content['reset_url'], $tokenMatches);
        $token = $tokenMatches[1] ?? null;

        preg_match('/email=([^&]+)/', $content['reset_url'], $emailMatches);
        $email = $emailMatches[1] ?? null;

        $password_old = User::where('email', '=', $email)->first()->makeVisible('password');

        $result_reset_password = $this->postJson('api/reset-password-user', [
            'email' => $email,
            'token' => $token,
            'password' => 'abc123123',
            'password_confirmation' => 'abc123123'
        ]);

        expect($result_reset_password->status())->toBe(200);

        $content = json_decode($result_reset_password->content(), true);

        expect($result_reset_password['message'])->toBe('Senha alterada com sucesso');

        $new_email = User::where('email', '=', $email)->first()->makeVisible('password');

        expect(
            Hash::check('abc123123', $new_email->password)
        )->toBeTrue();

        expect($new_email->password === $password_old)->toBeFalse();
    });

    it('check if reset password fails with no data', function () {
        $result_reset_password = $this->postJson('api/reset-password-user', []);

        expect($result_reset_password->status())->toBe(422);

        $content = json_decode($result_reset_password->content(), true);

        expect($content)->toHaveKey('errors');
        expect($content['errors'])->toHaveKey('email');
        expect($content['errors'])->toHaveKey('token');
        expect($content['errors'])->toHaveKey('password');
    });

    it('check if reset password fails with missing email', function () {
        $result_reset_password = $this->postJson('api/reset-password-user', [
            'token' => 'some_token',
            'password' => 'abc123123',
            'password_confirmation' => 'abc123123'
        ]);

        expect($result_reset_password->status())->toBe(422);

        $content = json_decode($result_reset_password->content(), true);

        expect($content)->toHaveKey('errors');
        expect($content['errors'])->toHaveKey('email');
    });

    it('check if reset password fails with missing token', function () {
        $result_reset_password = $this->postJson('api/reset-password-user', [
            'email' => 'test@example.com',
            'password' => 'abc123123',
            'password_confirmation' => 'abc123123'
        ]);

        expect($result_reset_password->status())->toBe(422);

        $content = json_decode($result_reset_password->content(), true);

        expect($content)->toHaveKey('errors');
        expect($content['errors'])->toHaveKey('token');
    });

    it('check if reset password fails with missing password', function () {
        $result_reset_password = $this->postJson('api/reset-password-user', [
            'email' => 'test@example.com',
            'token' => 'some_token'
        ]);

        expect($result_reset_password->status())->toBe(422);

        $content = json_decode($result_reset_password->content(), true);

        expect($content)->toHaveKey('errors');
        expect($content['errors'])->toHaveKey('password');
    });

    it('check if reset password fails with password confirmation mismatch', function () {
        $result_reset_password = $this->postJson('api/reset-password-user', [
            'email' => 'test@example.com',
            'token' => 'some_token',
            'password' => 'abc123123',
            'password_confirmation' => 'different_password'
        ]);

        expect($result_reset_password->status())->toBe(422);

        $content = json_decode($result_reset_password->content(), true);

        expect($content)->toHaveKey('errors');
        expect($content['errors'])->toHaveKey('password');
    });

    it('check if reset password fails with invalid email format', function () {
        $result_reset_password = $this->postJson('api/reset-password-user', [
            'email' => 'invalid_email',
            'token' => 'some_token',
            'password' => 'abc123123',
            'password_confirmation' => 'abc123123'
        ]);

        expect($result_reset_password->status())->toBe(422);

        $content = json_decode($result_reset_password->content(), true);

        expect($content)->toHaveKey('errors');
        expect($content['errors'])->toHaveKey('email');
    });

    it('check if reset password fails with invalid token', function () {
        $user = createUser();

        $result_reset_password = $this->postJson('api/reset-password-user', [
            'email' => $user->email,
            'token' => 'invalid_token',
            'password' => 'abc123123',
            'password_confirmation' => 'abc123123'
        ]);

        expect($result_reset_password->status())->toBe(400);

        $content = json_decode($result_reset_password->content(), true);

        expect($content['success'])->toBeFalse();
        expect($content['message'])->toContain('Token');
    });

    it('check if reset password fails with non existent email', function () {

        // não vai passar porque a validação requer que o email seja de um usuario
        $result_reset_password = $this->postJson('api/reset-password-user', [
            'email' => 'nonexistent@example.com',
            'token' => 'some_token',
            'password' => 'abc123123',
            'password_confirmation' => 'abc123123'
        ]);


        expect($result_reset_password->status())->toBe(422);
    });

    it('check if reset password fails with short password', function () {
        $user = createUser();

        $result_reset_password = $this->postJson('api/reset-password-user', [
            'email' => $user->email,
            'token' => 'some_token',
            'password' => '123',
            'password_confirmation' => '123'
        ]);

        expect($result_reset_password->status())->toBe(422);

        $content = json_decode($result_reset_password->content(), true);

        expect($content)->toHaveKey('errors');
        expect($content['errors'])->toHaveKey('password');
    });

    it('check if reset password fails with expired token', function () {
        $user = createUser();

        $result_reset_password = $this->postJson('api/reset-password-user', [
            'email' => $user->email,
            'token' => 'expired_token_simulation',
            'password' => 'abc123123',
            'password_confirmation' => 'abc123123'
        ]);

        expect($result_reset_password->status())->toBe(400);

        $content = json_decode($result_reset_password->content(), true);

        expect($content['success'])->toBeFalse();
        expect($content['message'])->toContain('Token inválido ou expirado');
    });
});