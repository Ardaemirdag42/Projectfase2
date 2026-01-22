<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ConsoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Home Page
|--------------------------------------------------------------------------
*/
Route::get('/', [GameController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Guest routes (niet ingelogd)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Gebruiker login/register
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    // Admin login/register
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

    Route::get('/admin/register', [AdminAuthController::class, 'showRegister'])->name('admin.register');
    Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');
});

/*
|--------------------------------------------------------------------------
| Authenticated user routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Library
    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
    Route::post('/library/add/{game}', [LibraryController::class, 'store'])->name('library.store');

    // Reviews
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Games beheren (admin-check IN de controller)
    Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    Route::get('/games/{game}/edit', [GameController::class, 'edit'])->name('games.edit');
    Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');
    Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');

    // Reviews verwijderen (admin-check IN controller)
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Consoles beheren (admin-check IN controller)
    Route::get('/consoles/create', [ConsoleController::class, 'create'])->name('consoles.create');
    Route::post('/consoles', [ConsoleController::class, 'store'])->name('consoles.store');
});

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/
// Games bekijken (voor iedereen)
Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');

// Reviews bekijken (voor iedereen)
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

/*
|--------------------------------------------------------------------------
| Winkelwagen routes (alleen voor gewone gebruikers)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', function () {
        $user = auth()->user();
        if ($user->is_admin) {
            abort(403, 'Admins kunnen geen winkelwagen gebruiken.');
        }
        return view('cart.index'); // maak deze view aan
    })->name('cart.index');

    Route::post('/cart/checkout', function () {
        $user = auth()->user();
        if ($user->is_admin) {
            abort(403, 'Admins kunnen geen winkelwagen gebruiken.');
        }
        // hier kan je de checkout logica plaatsen
        return redirect()->route('home')->with('success', 'Aankoop voltooid!');
    })->name('cart.checkout');
});
