<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\RoleController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'Hello world!']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::get('/me', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('/divisions')->group(function () {
        Route::get('/', [DivisionController::class, 'index']);
        Route::get('/{id}', [DivisionController::class, 'show']);
        Route::post('/', [DivisionController::class, 'store']);
        Route::put('/{id}', [DivisionController::class, 'update']);
        Route::delete('/{id}', [DivisionController::class, 'destroy']);
    });

    Route::prefix('/roles')->group(callback: function () {
        Route::get('/', [RoleController::class, 'index']);
        Route::get('/{id}', [RoleController::class, 'show']);
        Route::post('/', [RoleController::class, 'store']);
        Route::put('/{id}', [RoleController::class, 'update']);
        Route::delete('/{id}', [RoleController::class, 'destroy']);
    });
});
