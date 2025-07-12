<?php

use App\Http\Controllers\Api\AdmController;
use App\Http\Controllers\Api\Attendant;
use App\Http\Controllers\Api\ConsultationController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\MedicalRecordController;
use App\Http\Controllers\Api\Nurse;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/**
 * Public Routes (No Authentication Required)
 */
// Autenticação
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/image-protect/{filename}', [UserController::class, 'getImageProtected'])
    ->name('image.protected');
/**
 * Protected Routes (Authentication Required)
 */
Route::middleware('auth:sanctum')->group(function () {
    // User Routes
    Route::get('/user/patient', [UserController::class, 'UserPatient']);
    Route::get('/user/cpf/{cpf}', [UserController::class, 'cpf_verification'])
        ->name('patient.cpf_verification');
    Route::get('/user/flag', [UserController::class, 'userFlag']);
    Route::apiResource('/user', UserController::class);

    // Medical Records Routes
    Route::apiResource('/medical-record', MedicalRecordController::class);
    Route::get('/medical-record/search/{cpf}', [MedicalRecordController::class, 'show_records'])
        ->name('medical-records.show_records');
    Route::get('/medical-record/show/{id}', [MedicalRecordController::class, 'show'])
        ->name('medical-records.show');

    // Patient Routes
    Route::get('/patientCompleted', [PatientController::class, 'patientCompleted']);
    Route::apiResource('/patient', PatientController::class);

    // Staff Routes
    Route::apiResource('/attendant', Attendant::class);
    Route::apiResource('/doctor', DoctorController::class);
    Route::apiResource('/nurse', Nurse::class);
    Route::apiResource('/adm', AdmController::class);

    // Consultation Routes
    Route::apiResource('/consultation', ConsultationController::class);

    // Authentication Routes
    Route::get('/logout/{user}', [LoginController::class, 'logout'])->name('logout');
});