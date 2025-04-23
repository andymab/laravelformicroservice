<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;


Route::middleware(['apikey'])->group(
    function () {
        Route::post('/login', [LoginController::class, 'login']);
    }
);

Route::middleware(['auth:sanctum'])->group(
    function () {
        Route::post('/refresh', [LoginController::class, 'refresh']);
        Route::get('/user', function (Request $request) {
            return response()->json($request->user());
        });
    }
);
