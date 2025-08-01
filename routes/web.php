<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Clips\CommentController as ClipsCommentController;
use App\Http\Controllers\Clips\RateController as ClipsRateController;
use App\Http\Controllers\Clips\SubmitController as ClipsSubmitController;
use App\Http\Controllers\Clips\ViewController as ClipsViewController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'lander']);

Route::get('/auth/redirect', [AuthController::class, 'redirectToProvider'])->name('login');
Route::get('/auth/callback', [AuthController::class, 'handleProviderCallback']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'overview'])->name('overview');
    });

    Route::prefix('clips')->name('clips.')->group(function () {
        Route::get('/submit', [ClipsSubmitController::class, 'create'])->name('create');
        Route::post('/', [ClipsSubmitController::class, 'store'])->name('store');

        Route::get('/', [ClipsViewController::class, 'index'])->name('index');
        Route::get('/{clip}', [ClipsViewController::class, 'show'])->name('show');
        Route::get('/broadcaster/{broadcasterTwitchId}', [ClipsViewController::class, 'showByBroadcaster'])->name('by-broadcaster');
        Route::get('/game/{gameId}', [ClipsViewController::class, 'showByGame'])->name('by-game');

        Route::post('/{clip}/vote', [ClipsRateController::class, 'vote'])->name('vote');

        Route::post('/{clip}/comments', [ClipsCommentController::class, 'store'])->name('comments.store');
        Route::delete('/{clip}/comments/{comment}', [ClipsCommentController::class, 'destroy'])->name('comments.destroy');
    });
});

Route::prefix('users/{userTwitchId}')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'showAllClips'])->name('profile');
    Route::get('/broadcasted', [UserController::class, 'showBroadcastedClips'])->name('broadcasted');
    Route::get('/clipped', [UserController::class, 'showClippedClips'])->name('clipped');
    Route::get('/submitted', [UserController::class, 'showSubmittedClips'])->name('submitted');
});