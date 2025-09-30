<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;

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
        // Puedes agregar lógica personalizada aquí si lo deseas
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TokenInvalidException) {
            return response()->json(['error' => 'Token inválido'], 401);
        } elseif ($exception instanceof TokenExpiredException) {
            return response()->json(['error' => 'Token expirado'], 401);
        } elseif ($exception instanceof JWTException) {
            return response()->json(['error' => 'Token no enviado o inválido'], 401);
        }

        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        return response()->json(['error' => 'No autenticado'], 401);
    }
}
