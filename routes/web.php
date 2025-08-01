<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Clips\SubmitController as ClipsSubmitController;
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
    });

    Route::get('/clips/submit', [ClipsSubmitController::class, 'create'])->name('clips.create');
    Route::post('/clips', [ClipsSubmitController::class, 'store'])->name('clips.store');
});