<?php

use App\Http\Controllers\Api\AdmController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::apiResource('/user', UserController::class);
Route::apiResource('/adm', AdmController::class);
Route::apiResource('/patient', PatientController::class);