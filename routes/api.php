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
// use Illuminate\Support\Facades\Artisan;

Route::middleware('guest')->group(function () {
    // Autenticação
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    // pegar imagens
    Route::get('/image-protect/{filename}', [UserController::class, 'getImageProtected'])
        ->name('image.protected');

    // //roda migrations no banco em produção
    // Route::get('/run-migrations', function () {
    //     Artisan::call('migrate');
    //     return 'Migrations executadas com sucesso!';
    // });
});

//Protected Routes (Authentication Required)
Route::middleware('auth:sanctum')->group(function () {
    // User Routes
    Route::get('/user/patient', [UserController::class, 'UserPatient']);

    Route::get('/user/cpf/{cpf}', [UserController::class, 'cpf_verification'])
        ->name('patient.cpf_verification');

    Route::get('/user/flag', [UserController::class, 'userFlag']);

    // Medical Records Routes
    Route::get('/medical-record/search/{cpf}', [MedicalRecordController::class, 'show_records'])
        ->name('medical-records.show_records');

    Route::get('/medical-record/show/{id}', [MedicalRecordController::class, 'show'])
        ->name('medical-records.show');

    // Authentication Routes
    Route::get('/logout/{user}', [LoginController::class, 'logout'])->name('logout');

    // Patient Routes
    Route::get('/patientCompleted', [PatientController::class, 'patientCompleted']);

    Route::apiResources([
        '/medical-record' => MedicalRecordController::class,
        '/user' => UserController::class,
        '/patient' => PatientController::class,

        // Staff Routes
        '/attendant' => Attendant::class,
        '/doctor' => DoctorController::class,
        '/nurse' => Nurse::class,
        '/adm' => AdmController::class,
        // Consultation Routes
        '/consultation' => ConsultationController::class
    ]);
});