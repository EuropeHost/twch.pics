<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'lander']);

Route::get('/auth/redirect', [AuthController::class, 'redirectToProvider'])->name('login');
Route::get('/auth/callback', [AuthController::class, 'handleProviderCallback']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'overview'])->name('overview');
        // Add more dashboard routes here later, e.g.:
        // Route::get('/my-clips', [DashboardController::class, 'myClips'])->name('my-clips');
        // Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    });
});