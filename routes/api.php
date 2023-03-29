<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth')->group(function () {
        Route::get('profile', function () {
            return auth()->user();
        });
        Route::get('logout', [AuthController::class, 'logout']);
        Route::apiResource('books', BookController::class)
            ->only('index', 'show', 'store', 'update', 'destroy');
    });
});

Route::post('photo', function (\Illuminate\Http\Request $request) {
    $user = App\Models\User::find(1);
    $user->image()->create([
        'url' => $request->file('image')->store('users'),
    ]);
    return $user->image;
});