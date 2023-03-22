<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group( function() {
    Route::post('register', [RegisterController::class, 'register']);
});