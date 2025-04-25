<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/health', function (): Illuminate\Http\JsonResponse {
    return response()->json(['status' => 'ok']);
});
