<?php

use App\Http\Controllers\Api\Adm\AdmController;
use App\Http\Controllers\Api\Attendant\Attendant;
use App\Http\Controllers\Api\Bed\BedController;
use App\Http\Controllers\Api\ConsultationData\ConsultationController;
use App\Http\Controllers\Api\Doctor\DoctorController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Bed\JoinBetweenBedAndUser;
use App\Http\Controllers\Api\Bed\JoinManualBedFromPatient;
use App\Http\Controllers\Api\Bed\PatientForBed;
use App\Http\Controllers\Api\Bed\SeparateBedFromPatient;
use App\Http\Controllers\Api\Dashboard\DashboardController;
use App\Http\Controllers\Api\Mail\AtendeBemMail;
use App\Http\Controllers\Api\Record\MedicalRecordController;
use App\Http\Controllers\Api\Nurse\NurseController;
use App\Http\Controllers\Api\Patient\PatientCompletedController;
use App\Http\Controllers\Api\Patient\PatientController;
use App\Http\Controllers\Api\Record\ShowRecordsByCPFController;
use App\Http\Controllers\Api\Patient\SearchForPatientByCPFController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\User\UserFlagController;
use App\Http\Controllers\Api\User\UserPatientController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


//-------------------------------------------
// GUEST ROUTES (PUBLIC ACCESS)
//-------------------------------------------
Route::middleware('guest')->group(function () {
    //-----------------
    // AUTENTICAÇÃO
    //-----------------
    Route::post('/login', [LoginController::class, 'login']);

    //-----------------------
    // EMAIL RESET PASSWORD
    //-----------------------
    Route::post('/reset-password-email', [AtendeBemMail::class, 'sendTokenEmail']);

    Route::post('/reset-password-user', [App\Http\Controllers\Api\Mail\Reset_Password::class, 'reset_password']);

    Route::get('/health', function () {
        try {
            DB::connection()->getPdo();
            return response()->json([
                'alive' => true,
                'db'    => 'ok'
            ], 200);
        } catch (Exception $e) {
            $message = env('APP_ENV') === 'local'
                ? $e->getMessage()
                : 'database connection failed';

            return response()->json([
                'alive'  => false,
                'db'     => 'fail',
                'error'  => $message
            ], 500);
        }
    });
});


//-------------------------------------------
// PROTECTED ROUTES (AUTHENTICATION REQUIRED)
//-------------------------------------------
Route::middleware('auth:sanctum')->group(function () {

    //-----------------
    // DASHBOARD DATA
    //-----------------
    Route::get('/dashboard', DashboardController::class);

    //-----------------
    // USER ROUTES
    //-----------------
    Route::get('/user/patient', UserPatientController::class);

    Route::get('/user/cpf/{cpf}', SearchForPatientByCPFController::class);

    Route::get('/user/flag', UserFlagController::class);


    //--------------------------
    // MEDICAL RECORDS ROUTES
    //--------------------------
    Route::get('/medical-record/search/{cpf}', ShowRecordsByCPFController::class);

    Route::get('/medical-record/show/{id}', [MedicalRecordController::class, 'show']);


    //--------------------------
    // AUTHENTICATION ROUTES
    //--------------------------
    Route::get('/logout/{user}', LogoutController::class);

    //--------------------------
    // PATIENT ROUTES
    //--------------------------
    Route::get('/patientCompleted', PatientCompletedController::class);

    //--------------------------
    // JOIN BED WITH USER
    //--------------------------
    Route::post('/bed-with-patient', JoinBetweenBedAndUser::class);

    Route::post('/bed-separate-patient', SeparateBedFromPatient::class);

    Route::post('/join-bed-manual-patient', JoinManualBedFromPatient::class);

    Route::get('/patient-for-bed', PatientForBed::class);

    //--------------------------
    // ROTAS PADRÕES PARA CRUD
    //--------------------------
    Route::apiResources([
        '/medical-record' => MedicalRecordController::class,
        '/user' => UserController::class,
        '/patient' => PatientController::class,

        //--------------------------
        // STAFF ROUTES
        //--------------------------
        '/attendant' => Attendant::class,
        '/doctor' => DoctorController::class,
        '/nurse' => NurseController::class,
        '/adm' => AdmController::class,

        //--------------------------
        // CONSULTATION ROUTES
        //--------------------------
        //--------------------------
        '/consultation' => ConsultationController::class,

        //--------------------------
        // BED
        //--------------------------
        '/bed-management' => BedController::class
    ]);
});