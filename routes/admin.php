<?php

use App\Http\Controllers\AdminReviewController;

Route::middleware(['auth', 'role:admin'])->group(function() {
    Route::get('/reviews/moderation', [AdminReviewController::class, 'index'])
        ->name('admin.reviews.index');

    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])
        ->name('admin.reviews.destroy');
});
