<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    public function register()
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->view('errors.404', [], 404);
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            return response()->view('errors.404', [], 404);
        });
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return response()->view('errors.404', [], 404);
        });
    }
}
