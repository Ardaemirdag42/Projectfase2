<?php

use App\Http\Controllers\ReservationController;

Route::get('/', [ReservationController::class, 'index']);
Route::get('/reservations/create', [ReservationController::class, 'create']);
Route::post('/reservations', [ReservationController::class, 'store']);
Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit']);
Route::put('/reservations/{id}', [ReservationController::class, 'update']);
Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);