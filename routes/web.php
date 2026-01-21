<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ReviewController;

// AUTH ROUTES
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// GAMES
Route::get('/', [GameController::class, 'index'])->name('games.index');
Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');

Route::middleware(['auth'])->group(function () {
    // Library routes
    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
    Route::post('/library/add/{game}', [LibraryController::class, 'store'])->name('library.store');

    // Review opslaan (POST) alleen voor ingelogde users
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Reviews bekijken (GET, voor iedereen)
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

// Review aanmaken formulier (alleen ingelogde users)
Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create')->middleware('auth');