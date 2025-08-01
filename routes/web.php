<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;

Route::get('/', [PageController::class, 'lander']);

Route::get('/auth/redirect', [AuthController::class, 'redirectToProvider'])->name('login');
Route::get('/auth/callback', [AuthController::class, 'handleProviderCallback']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return 'Welcome to your dashboard!'; // Placeholder
    })->name('dashboard');
});
