<?php

namespace App\Exceptions;

use App\Http\Controllers\ResponseHelper;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler
{

    use ResponseHelper;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception):JsonResponse
    {
        // Handle AuthorizationException
        if ($exception instanceof AuthorizationException) {
            return $this->Error([], 'You do not have the required authorization', 403);
        }

        // Handle NotFoundHttpException
        if ($exception instanceof NotFoundHttpException) {
            return $this->Error([], 'Resource not found', 404);
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            return $this->Validation($exception->errors(), 'Validation error', 422);
        }

        // if ($this->isHttpException($exception)) {
        //     $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;
        //     return $this->Error([], $exception->getMessage(), $statusCode);
        // }

        // Default handling for other exceptions
        return $this->Error([], $exception->getMessage(), 500);
    }
}
