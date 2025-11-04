<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
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


require __DIR__.'/auth.php';
