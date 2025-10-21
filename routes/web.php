<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Mail\ResetPassword;

Route::get('/', function () {
    abort(404);
});

// Rota para exibir o formulário de reset de senha
Route::get('/reset-password', [ResetPassword::class, 'showResetForm'])
    ->name('show.reset.form')
    ->middleware('web');

// Rota para processar o reset de senha
Route::post('/reset-password', [ResetPassword::class, 'resetPassword'])
    ->name('reset.password')
    ->middleware('web');
