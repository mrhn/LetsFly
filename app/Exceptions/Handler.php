<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return JsonResponse
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return $this->formatToJsend(
                array_last(explode("\\", $exception->getModel())) . ' not found',
                JsonResponse::HTTP_NOT_FOUND,
                'fail'
            );
        }

        if ($exception instanceof ValidationException) {
            return $this->formatToJsend(
                'Validation error',
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'fail',
                $exception->errors()
            );
        }

        return $this->formatToJsend(
            'Critical error',
            JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'error'
        );
    }

    private function formatToJsend(string $message, int $code, string $status, array $data = null): JsonResponse
    {
        return new JsonResponse([
            'message' => $message,
            'code' => $code,
            'status' => $status,
            'data' => $data,
        ], $code);
    }
}
