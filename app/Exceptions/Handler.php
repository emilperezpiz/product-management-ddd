<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
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
     *
     * @return void
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return $this->handleApiErrors($e);
            }
        });
    }

    private function handleApiErrors(Throwable $e): JsonResponse
    {
        $status = $this->getStatusCode($e);
        return response()->json([
            'data' => [],
            'message' => $e->getMessage(),
            'details' => ($e instanceof ValidationException) ? $e->errors() : null,
        ], $status);
    }

    private function getStatusCode(Throwable $e): int
    {
        if ($e instanceof ValidationException) {
            return Response::HTTP_UNPROCESSABLE_ENTITY;
        }
        if ($e instanceof NotFoundHttpException) {
            return Response::HTTP_NOT_FOUND;
        }
        if (method_exists($e, 'getStatusCode')) {
            return $e->getStatusCode();
        }
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
