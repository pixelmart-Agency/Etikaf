<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use App\Responses\{ErrorResponse};
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
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
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
    {
        if (
            $exception instanceof NotFoundHttpException || $exception instanceof ModelNotFoundException
        ) {
            // تحقق إذا كان الطلب عبر API
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => __('translation.wrong_route'),
                ], 404);
            }
        }
        if ($exception instanceof ValidationException && $request->wantsJson()) {
            $firstError = collect($exception->errors())->flatten()->first();
            return ErrorResponse::send($firstError, 422);
        }


        return parent::render($request, $exception);
    }
}
