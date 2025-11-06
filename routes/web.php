<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventarisController;
use Illuminate\Support\Facades\Route;

// Reservation routes
Route::get('/reservations', [ReservationController::class, 'index']);
Route::get('/reservations/create', [ReservationController::class, 'create']);
Route::post('/reservations', [ReservationController::class, 'store']);
Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit']);
Route::put('/reservations/{id}', [ReservationController::class, 'update']);
Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);

// Dashboard & Auth routes
Route::get('/', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/inventaris', [InventarisController::class, 'index'])->name('inventaris.index');
    Route::get('/inventaris/create', [InventarisController::class, 'create'])->name('inventaris.create');
    Route::post('/inventaris', [InventarisController::class, 'store'])->name('inventaris.store');
    Route::get('/inventaris/{id}/edit', [InventarisController::class, 'edit'])->name('inventaris.edit');
    Route::put('/inventaris/{id}', [InventarisController::class, 'update'])->name('inventaris.update');
    Route::delete('/inventaris/{id}', [InventarisController::class, 'destroy'])->name('inventaris.destroy');

    Route::get('/inventaris/{id}/mutaties', [InventarisController::class, 'mutaties'])->name('inventaris.mutaties');
    Route::post('/inventaris/{id}/mutaties', [InventarisController::class, 'voegMutatieToe'])->name('inventaris.voegMutatieToe');
});

require __DIR__ . '/auth.php';

