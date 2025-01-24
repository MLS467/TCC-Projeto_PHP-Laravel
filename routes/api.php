<?php

use App\Http\Controllers\Api\AdmController;
use App\Http\Controllers\Api\Attendant;
use App\Http\Controllers\Api\ConsultationController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\Nurse;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [LoginController::class, 'login'])->name('login');


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/patient', [UserController::class, 'UserPatient']);
    Route::get('/user/flag', [UserController::class, 'userFlag']);
    Route::get('/patientCompleted', [PatientController::class, 'patientCompleted']);

    Route::apiResource('/attendant', Attendant::class);
    Route::apiResource('/doctor', DoctorController::class);
    Route::apiResource('/nurse', Nurse::class);

    Route::get('/logout/{user}', [LoginController::class, 'logout'])->name('logout');

    Route::apiResource('/user', UserController::class);
    Route::apiResource('/adm', AdmController::class);
    Route::apiResource('/patient', PatientController::class);
    Route::apiResource('/consultation', ConsultationController::class);
});