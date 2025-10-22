<?php

beforeEach(function () {
    $this->email_unknow = 'teste@teste.com';
});

describe('check if forgot password', function () {

    it('check if the method return a token', function () {

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
    });


    it('check with email unknow', function () {

        $result = $this->postJson('api/reset-password-email', [
            'email' => $this->email_unknow
        ]);

        expect($result->status())->toBe(404);

        $content = json_decode($result->content(), true);
        expect($content['success'])->toBeFalse();
    });

    it('check with email empty', function () {

        $result = $this->postJson('api/reset-password-email', [
            'email' => ''
        ]);

        // 422 Unprocessable Entity
        expect($result->status())->toBe(422);
    });
});