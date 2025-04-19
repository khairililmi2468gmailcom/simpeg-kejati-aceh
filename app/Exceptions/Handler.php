<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

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
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();

            if (view()->exists("errors.{$statusCode}")) {
                return response()->view("errors.{$statusCode}", [
                    'user' => Auth::user(),
                ], $statusCode);
            }
        }

        return parent::render($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register()
    {
        // Menangani error 404 (route tidak ditemukan)
        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->view('errors.404', [
                'user' => Auth::user()
            ], 404);
        });

        // Menangani error jika request method tidak sesuai (misal: POST ke route GET)
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return response()->view('errors.404', [
                'user' => Auth::user()
            ], 404);
        });

        // Menangani error jika user tidak terautentikasi (bisa juga diarahkan ke login)
        $this->renderable(function (AuthenticationException $e, $request) {
            return response()->view('errors.404', [
                'user' => Auth::user()
            ], 404);
        });
    }
}
