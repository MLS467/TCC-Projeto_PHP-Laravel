<?php

namespace Tests\Unit\LoginTest\traitLoginTest;

trait Login
{
    protected string $baseUrl = "http://localhost:8082";
    protected array $credentials = [
        'email' => "teste@doutora.com",
        'password' => 12345678
    ];
    protected array $credentialsErrorPassword = [
        'email' => "teste@doutora.com",
        'password' => ''
    ];
    protected array $credentialsErrorEmail = [
        'email' => "",
        'password' => 12345678
    ];
    protected array $credentialsErrorPasswordIncomplete = [
        'email' => "teste@doutora.com",
        'password' => 12345
    ];
    protected array $credentialsErrorEmailIncomplete = [
        'email' => "",
        'password' => 12345
    ];
    protected array $credentialsErrorFildsNotExists = [
        'email' => "teste@babalu.com",
        'password' => '123dabliobrasil'
    ];
    protected array $CredentialsInvalids = [
        'email' => "testebabalu.com",
        'password' => '@#$%¨&*&*())_++'
    ];
}