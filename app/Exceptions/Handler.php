<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Inertia\Inertia;
use Throwable;

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

    function render($request, Throwable $exception) {
        if ($this->isHttpException($exception)) {
            // return response()->view('error.error', [
            //     "code" => $code,
            //     "message" => $exception->getMessage()
            // ], $code);
            return Inertia::render("Error/Index", [
                "code" => $exception->getStatusCode()
            ])->toResponse($request)->setStatusCode($exception->getStatusCode());
        }
        return parent::render($request, $exception);
    }
}
