<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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

    public function render($request, Throwable $exception)
    {
        // Check if the exception is an instance of MethodNotAllowedHttpException
        if ($exception instanceof MethodNotAllowedHttpException) {
            // Method not allowed (e.g., POST to a route expecting GET)
            return $this->errorResponse('Method not allowed. Please check your request method.', 405);
        }

        // Check if the exception is an instance of NotFoundHttpException
        if ($exception instanceof NotFoundHttpException) {
            // Route not found (404 error)
            return $this->errorResponse('Route not found', 404);
        }

        // Handle generic HTTP exceptions (e.g., 500, 413, etc.)
        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();

            switch ($statusCode) {
                case 500:
                    return $this->errorResponse('Server Error. Contact admin', 500);
                case 413:
                    return $this->errorResponse('Payload too large.', 413);
                case 401:
                    return $this->errorResponse($exception->getMessage(), 401);
                default:
                    return $this->errorResponse('An unexpected error occurred.', $statusCode);
            }
        }

        if ($exception instanceof ValidationException) {

            return $this->errorResponse($exception->getMessage(), '422');

        }
        // For any other type of exception (non-HTTP), return a generic response
        return $this->errorResponse($exception->getMessage(), 502);
    }

    public function errorResponse($error, $code = 401, $errorMessages = [])
    {

        $statusCode = $code == 0 ? 401 : $code;
        $response = [
            'success' => false,
            'status_code' => $statusCode,
            'message' => is_array($error) == TRUE ? $error : [$error],
            'data'    => []
        ];

        return response()->json($response, $statusCode);
    }
}
