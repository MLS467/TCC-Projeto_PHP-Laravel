<?php

use App\Http\Controllers\Api\Adm\AdmController;
use App\Http\Controllers\Api\Attendant\Attendant;
use App\Http\Controllers\Api\ConsultationData\ConsultationController;
use App\Http\Controllers\Api\Doctor\DoctorController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Dashboard\DashboardController;
use App\Http\Controllers\Api\Record\MedicalRecordController;
use App\Http\Controllers\Api\Nurse\Nurse;
use App\Http\Controllers\Api\Patient\PatientCompletedController;
use App\Http\Controllers\Api\Patient\PatientController;
use App\Http\Controllers\Api\Record\ShowRecordsByCPFController;
use App\Http\Controllers\Api\Patient\SearchForPatientByCPFController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\User\UserFlagController;
use App\Http\Controllers\Api\User\UserGetImageProtectedController;
use App\Http\Controllers\Api\User\UserPatientController;
use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Artisan;

Route::middleware('guest')->group(function () {
    // Autenticação
    Route::post('/login', [LoginController::class, 'login'])->name('login');


    // pegar imagens
    Route::get('/image-protect/{filename}', UserGetImageProtectedController::class);


    Route::get('/dashboard', DashboardController::class);
});

//Protected Routes (Authentication Required)
Route::middleware('auth:sanctum')->group(function () {

    // User Routes
    Route::get('/user/patient', UserPatientController::class);

    Route::get('/user/cpf/{cpf}', SearchForPatientByCPFController::class);

    Route::get('/user/flag', UserFlagController::class);


    // Medical Records Routes
    Route::get('/medical-record/search/{cpf}', ShowRecordsByCPFController::class);

    Route::get('/medical-record/show/{id}', [MedicalRecordController::class, 'show']);


    // Authentication Routes
    Route::get('/logout/{user}', LogoutController::class);

    // Patient Routes
    Route::get('/patientCompleted', PatientCompletedController::class);


    // Rotas padrões para crud
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