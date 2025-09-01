<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A lista de exceções que não devem ser reportadas.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A lista de inputs que nunca devem ser mostrados em erros de validação.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registrar callbacks para tratamento de exceções.
     */
    public function register(): void
    {
        $this->renderable(function (ConsultationException $e, $request) {
            $statusCode = $e->getCode() ?: 500;

            if (env('APP_ENV') == 'local') {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'error' => [$e->getTraceAsString()],
                ], $statusCode);
            }

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], $statusCode);
        });

        $this->renderable(function (AuthException $e, $request) {
            $statusCode = $e->getCode() ?: 500;

            if (env('APP_ENV') == 'local') {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'error' => [$e->getTraceAsString()],
                ], $statusCode);
            }

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], $statusCode);
        });

        $this->renderable(function (PatientException $e, $request) {
            $statusCode = $e->getCode() ?: 500;

            if (env('APP_ENV') == 'local') {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'error' => [$e->getTraceAsString()],
                ], $statusCode);
            }

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], $statusCode);
        });

        $this->renderable(function (MedicalException $e, $request) {
            $statusCode = $e->getCode() ?: 500;

            if (env('APP_ENV') == 'local') {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'error' => [$e->getTraceAsString()],
                ], $statusCode);
            }

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], $statusCode);
        });

        $this->renderable(function (UserException $e, $request) {
            $statusCode = $e->getCode() ?: 500;

            if (env('APP_ENV') == 'local') {
                return response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                    'error' => [$e->getTraceAsString()],
                ], $statusCode);
            }

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], $statusCode);
        });
    }
}