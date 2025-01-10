<?php

use App\Http\Controllers\Api\AdmController;
use App\Http\Controllers\Api\ConsultationController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/user/patient', [UserController::class, 'UserPatient']);
Route::get('/user/flag', [UserController::class, 'userFlag']);
Route::get('/patientCompleted', [PatientController::class, 'patientCompleted']);


Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::apiResource('/user', UserController::class);
Route::apiResource('/adm', AdmController::class);
Route::apiResource('/patient', PatientController::class);
Route::apiResource('/consultation', ConsultationController::class);