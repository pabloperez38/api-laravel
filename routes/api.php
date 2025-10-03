<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;

Route::apiResource('categorias', CategoriaController::class);

// GET → Listar todos


// POST → Crear nuevo


// GET → Mostrar uno en particular
//Route::get('productos/{producto}', [ProductoController::class, 'show']);

// PUT → Actualizar completamente
//Route::put('productos/{producto}', [ProductoController::class, 'update']);

// PATCH → Actualizar parcialmente
//Route::patch('productos/{producto}', [ProductoController::class, 'update']);

// DELETE → Eliminar
//Route::delete('productos/{producto}', [ProductoController::class, 'destroy']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas con JWT
Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('productos', ProductoController::class);
});
