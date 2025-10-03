<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;


class Handler extends ExceptionHandler
{
    /**
     * Una lista de las excepciones que no se deben reportar.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * Una lista de las entradas que nunca se deben mostrar en las respuestas de validación.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registra los callbacks para el manejo de excepciones.
     */
    public function register(): void
    {
        //
    }

    /**
     * Renderiza las excepciones a una respuesta HTTP.
     */
    public function render($request, Throwable $exception)
    {
        // Forzar JSON en rutas API
        if ($request->expectsJson() || $request->is('api/*')) {
            if ($exception instanceof TokenInvalidException) {
                return response()->json(['error' => 'Token inválido'], 401);
            } elseif ($exception instanceof TokenExpiredException) {
                return response()->json(['error' => 'Token expirado'], 401);
            } elseif ($exception instanceof JWTException) {
                return response()->json(['error' => 'Token no enviado o inválido'], 401);
            } elseif ($exception instanceof AuthenticationException) {
                return response()->json(['error' => 'No autenticado'], 401);
            }

            if ($exception instanceof UnauthorizedHttpException) {
                $message = $exception->getMessage() ?: 'No autenticado';
                return response()->json(['error' => $message], 401);
            }
        }

        return parent::render($request, $exception);
    }

    /**
     * Maneja usuarios no autenticados.
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['error' => 'No autenticado'], 401);
    }
}
