<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::middleware(['apikey'])->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
});
